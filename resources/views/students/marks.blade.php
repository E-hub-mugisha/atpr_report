@extends('layouts.app')
@section('title', 'View Student Marks')
@section('content')

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold">
                <i class="bi bi-clipboard2-data-fill me-2"></i> Student Marks Overview
            </h4>
        </div>

        <div class="card-body bg-light-subtle">

            @if($student)
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-light rounded-top-4">
                    <h5 class="fw-bold text-primary mb-0">
                        <i class="bi bi-person-badge me-1"></i>
                        {{ $student->first_name }} {{ $student->last_name }}
                        <small class="text-muted">({{ $student->student_id }})</small>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Module</th>
                                    <th>IA</th>
                                    <th>FA</th>
                                    <th>CA</th>
                                    <th>Total</th>
                                    <th>Reass</th>
                                    <th>Obs</th>
                                    <th>Remarks</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->marks as $mark)
                                <tr>
                                    <td>{{ $mark->lesson->title ?? 'N/A' }}</td>
                                    <td>{{ $mark->i_a }}</td>
                                    <td>{{ $mark->f_a }}</td>
                                    <td>{{ $mark->c_a }}</td>
                                    <td><strong>{{ $mark->total }}</strong></td>
                                    <td>{{ $mark->reass }}</td>
                                    <td>{{ $mark->obs }}</td>
                                    <td>{{ $mark->remarks }}</td>
                                    <td class="text-muted small">{{ $mark->updated_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-info rounded-3 mt-3">
                <i class="bi bi-info-circle me-1"></i> No marks available for this student yet.
            </div>
            @endif
        </div>
    </div>
</div>

@endsection