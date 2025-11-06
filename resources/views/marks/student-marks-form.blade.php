@extends('layouts.app')
@section('title', 'Select Student')

@section('content')
<div class="container">
    <h3>Select a Student to View Marks for Module: {{ $module->title }}</h3>
    <form action="{{ route('modules.student-marks.show', $module) }}" method="GET">
        <div class="mb-3">
            <label for="student" class="form-label">Student</label>
            <select name="student" id="student" class="form-select" required>
                <option value="" disabled selected>Select a student</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">View Marks</button>
    </form>
</div>
@endsection
