@extends('layouts.app')
@section('title', 'Student Report')
@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <h4 class="mb-4">Generate Student Report</h4>

        <!-- Select Student -->
        <form action="{{ route('students.report') }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Select Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">-- Choose Student --</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ (isset($selectedStudent) && $selectedStudent->id == $student->id) ? 'selected' : '' }}>
                            {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">View Report</button>
                </div>
            </div>
        </form>

        @if(isset($selectedStudent))
        <h5 class="mt-4 mb-3">Report for: {{ $selectedStudent->first_name }} {{ $selectedStudent->last_name }}</h5>

        <div class="accordion" id="modulesAccordion">
            @foreach($modules as $module)
            <div class="accordion-item mb-2">
                <h2 class="accordion-header" id="headingModule{{ $module->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModule{{ $module->id }}">
                        {{ $module->title }}
                    </button>
                </h2>
                <div id="collapseModule{{ $module->id }}" class="accordion-collapse collapse">
                    <div class="accordion-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Lesson</th>
                                    <th>IA</th>
                                    <th>FA</th>
                                    <th>CA</th>
                                    <th>Total</th>
                                    <th>Re-assessment</th>
                                    <th>Observation</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($module->lessons as $lesson)
                                @php
                                $mark = $lesson->marks->first();
                                @endphp
                                <tr>
                                    <td>{{ $lesson->title }}</td>
                                    <td>{{ $mark->i_a ?? '-' }}</td>
                                    <td>{{ $mark->f_a ?? '-' }}</td>
                                    <td>{{ $mark->c_a ?? '-' }}</td>
                                    <td>{{ $mark->total ?? '-' }}</td>
                                    <td>{{ $mark->reass ?? '-' }}</td>
                                    <td>{{ $mark->obs ?? '-' }}</td>
                                    <td>{{ $mark->remarks ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No lessons in this module</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Generate Report Button -->
        <form action="{{ route('students.report.generate') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
            <button class="btn btn-success">Generate Report</button>
        </form>

        <div class="mt-3">
            <form action="{{ route('students.report.pdf') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                <button class="btn btn-danger">Download PDF</button>
            </form>
            <form action="{{ route('students.report.excel') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                <button class="btn btn-success">Download Excel</button>
            </form>
        </div>

        @endif
    </div>
</div>

@endsection