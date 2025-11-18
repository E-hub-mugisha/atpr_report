@extends('layouts.app')
@section('title', 'Student Evaluation Details')
@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Student Evaluation Details</h3>
        <a href="{{ route('evaluations.export', $evaluation->id) }}" class="btn btn-primary">
            Export PDF
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <h5 class="fw-bold mb-3">Module Detail</h5>
        <p><strong>Sector:</strong> {{ $evaluation->module->sector }}</p>
        <p><strong>Sub-Sector / Trade:</strong> {{ $evaluation->module->trade }}</p>
        <p><strong>Level:</strong> {{ $evaluation->module->level }}</p>
        <p><strong>Occupational Title:</strong> {{ $evaluation->module->title }}</p>
        <p><strong>Module:</strong> {{ $evaluation->module->code }} - {{ $evaluation->module->name }}</p>

        <hr>

        <h5 class="fw-bold mb-3">Student Information</h5>
        <p><strong>Name:</strong> {{ $evaluation->student->full_name }}</p>
        <p><strong>Student Nbr:</strong> {{ $evaluation->student->student_id }}</p>

        <hr>

        <h5 class="fw-bold mb-3">Trainer Information</h5>
        <p><strong>Name:</strong> {{ $evaluation->trainer->first_name }} {{ $evaluation->trainer->last_name }}</p>

        <hr>

        <h5 class="fw-bold mb-3">Learning Outcomes & Performance Criteria</h5>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="25%">Learning Outcome</th>
                    <th>Performance Criteria</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluation->learningOutcomes as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach($item->performanceCriteria as $pc)
                                    <li>{{ $pc->description }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
@endsection
