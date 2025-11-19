@extends('layouts.app')
@section('title', 'Student Marks Overview')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <!-- Header -->
            <div class="nk-block nk-block-lg mb-4">
                <h3 class="fw-bold text-primary">
                    <em class="icon ni ni-student"></em>
                    Student Marks Overview
                </h3>
                <p class="text-muted mb-3">
                    View all students and their marks grouped per module and lesson.
                </p>
            </div>

            <!-- Table -->
            <div class="card card-bordered card-preview mt-3">
                <div class="card-inner table-responsive">
                    <table class="table table-bordered align-middle ">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                @foreach($modules as $module)
                                    @foreach($module->lessons as $lesson)
                                        <th>{{ $lesson->title }}</th>
                                    @endforeach
                                    <th>Module Total</th>
                                @endforeach
                                <th>Total Marks</th>
                                <th>Percentage</th>
                                <th>Analysis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                                @php
                                    $studentTotal = 0;
                                    $studentMaxTotal = 0;
                                    $studentRemarks = [];
                                    $studentObservations = [];
                                    $studentDecisions = [];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start">{{ $student->first_name }} {{ $student->last_name }}</td>

                                    @foreach($modules as $module)
                                        @php
                                            $moduleTotal = 0;
                                            $moduleMaxTotal = $module->lessons->count() * 100; // assuming max 100 per lesson
                                        @endphp
                                        @foreach($module->lessons as $lesson)
                                            @php
                                                $mark = $student->marks->firstWhere('lesson_id', $lesson->id);
                                                $score = $mark->total ?? null;
                                                if($score !== null){
                                                    $moduleTotal += $score;
                                                }
                                                $obs = $mark->obs ?? '';
                                                if($obs) $studentObservations[] = $obs;
                                                if($score !== null && $score < 50){
                                                    $studentRemarks[] = "Low mark in {$lesson->title}";
                                                }
                                            @endphp
                                            <td class="{{ $score === null ? 'text-muted' : ($score < 50 ? 'bg-danger text-white' : ($score < 60 ? 'bg-warning text-dark' : 'bg-success text-white')) }}">
                                                {{ $score ?? '-' }}
                                            </td>
                                        @endforeach
                                        @php
                                            $modulePercentage = $moduleMaxTotal ? round($moduleTotal / $moduleMaxTotal * 100, 2) : 0;
                                            $moduleDecision = $modulePercentage >= 50 ? 'C' : 'NYC';
                                            $studentDecisions[] = "{$module->title}: {$moduleDecision}";
                                            $studentTotal += $moduleTotal;
                                            $studentMaxTotal += $moduleMaxTotal;
                                        @endphp
                                        <td>{{ $moduleTotal }}</td>
                                    @endforeach

                                    @php
                                        $percentage = $studentMaxTotal ? round($studentTotal / $studentMaxTotal * 100, 2) : 0;
                                        $decision = $percentage >= 50 ? 'C' : 'NYC';
                                    @endphp
                                    <td>{{ $studentTotal }}</td>
                                    <td>{{ $percentage }}%</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#analysisModal{{ $student->id }}">
                                            View
                                        </button>

                                        <!-- Analysis Modal -->
                                        <div class="modal fade" id="analysisModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header bg-light border-0 rounded-top-4">
                                                        <h5 class="modal-title fw-bold text-primary">
                                                            Analysis for {{ $student->first_name }} {{ $student->last_name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body bg-light-subtle">
                                                        <p><strong>Total Marks:</strong> {{ $studentTotal }}</p>
                                                        <p><strong>Percentage:</strong> {{ $percentage }}%</p>
                                                        <p><strong>Overall Decision:</strong>
                                                            @if($decision == 'C')
                                                                <span class="badge bg-success">C</span>
                                                            @else
                                                                <span class="badge bg-danger">NYC</span>
                                                            @endif
                                                        </p>
                                                        <hr>
                                                        <p><strong>Module Decisions:</strong></p>
                                                        <ul>
                                                            @foreach($studentDecisions as $md)
                                                                <li>{{ $md }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <hr>
                                                        <p><strong>Remarks:</strong></p>
                                                        <ul>
                                                            @forelse($studentRemarks as $remark)
                                                                <li>{{ $remark }}</li>
                                                            @empty
                                                                <li>-</li>
                                                            @endforelse
                                                        </ul>
                                                        <hr>
                                                        <p><strong>Observations:</strong></p>
                                                        <ul>
                                                            @forelse($studentObservations as $obs)
                                                                <li>{{ $obs }}</li>
                                                            @empty
                                                                <li>-</li>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer border-0 bg-light rounded-bottom-4">
                                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
