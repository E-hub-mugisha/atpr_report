@extends('layouts.app')

@section('content')

@php
use App\Models\Trainer;
$trainers = Trainer::all();
@endphp

<div class="container">
    <h2 class="mb-4">Courses</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>

    @foreach ($courses as $course)
    <div class="card mb-2">
        <div class="card-body">
            <h5>{{ $course->name }} ({{ $course->duration }} hrs)</h5>
            <p>{{ $course->description }}</p>
            <small>Trainer: {{ $course->trainer ?? 'Unassigned' }}</small><br>
            <a href="{{ route('courses.modules.index', $course) }}" class="btn btn-sm btn-outline-secondary me-1">
                📦 View Modules
            </a>

            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#showCourseModal{{ $course->id }}">Show</button>
            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id }}">Edit</button>
            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#assignTrainerModal{{ $course->id }}">🎓 Assign Trainer</button>

            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <!-- Assign Trainer Modal -->
    <div class="modal fade" id="assignTrainerModal{{ $course->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('courses.update', $course) }}">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Trainer</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Select Trainer</label>
                            <select name="trainer" class="form-select" required>
                                <option value="">-- Choose Trainer --</option>
                                @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->name }}" @if($course->trainer == $trainer->name) selected @endif>
                                    {{ $trainer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Preserve other course data -->
                        <input type="hidden" name="name" value="{{ $course->name }}">
                        <input type="hidden" name="description" value="{{ $course->description }}">
                        <input type="hidden" name="duration" value="{{ $course->duration }}">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Show Modal -->
    <div class="modal fade" id="showCourseModal{{ $course->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Course Details</h5>
                </div>
                <div class="modal-body">
                    <strong>Name:</strong> {{ $course->name }}<br>
                    <strong>Description:</strong> {{ $course->description }}<br>
                    <strong>Duration:</strong> {{ $course->duration }} hrs<br>
                    <strong>Trainer:</strong> {{ $course->trainer ?? 'Unassigned' }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('courses.update', $course) }}">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Course</h5>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" value="{{ $course->name }}" class="form-control mb-2" required>
                        <textarea name="description" class="form-control mb-2">{{ $course->description }}</textarea>
                        <input type="number" name="duration" value="{{ $course->duration }}" class="form-control mb-2" required>
                        <input type="text" name="trainer" value="{{ $course->trainer }}" class="form-control mb-2">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Add Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Course</h5>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Course Name" required>
                        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                        <input type="number" name="duration" class="form-control mb-2" placeholder="Duration (hrs)" required>
                        <input type="text" name="trainer" class="form-control mb-2" placeholder="Trainer Name">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{ $courses->links() }}
</div>
@endsection