@extends('layouts.app')
@section('title', 'Courses')
@section('content')

@php
use App\Models\Trainer;
$trainers = Trainer::all();
@endphp

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Courses</h3>
                        <div class="nk-block-des text-soft">
                            <p>You have total {{ $courses->count() }} Courses.</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle"><a href="#"
                                class="btn btn-icon btn-trigger toggle-expand me-n1"
                                data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="drodown"><a href="#"
                                                class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                                data-bs-toggle="dropdown"><em
                                                    class="d-none d-sm-inline icon ni ni-filter-alt"></em><span>Filtered
                                                    By</span><em
                                                    class="dd-indc icon ni ni-chevron-right"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>Open</span></a></li>
                                                    <li><a href="#"><span>Closed</span></a></li>
                                                    <li><a href="#"><span>Onhold</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nk-block-tools-opt d-none d-sm-block"><a href="#"
                                            class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal"><em
                                                class="icon ni ni-plus"></em><span>Add
                                                Course</span></a></li>
                                    <li class="nk-block-tools-opt d-block d-sm-none"><a href="#"
                                            class="btn btn-icon btn-primary"><em
                                                class="icon ni ni-plus"></em></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="row g-gs">
                        @foreach ($courses as $course)
                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="project">
                                        <div class="project-head"><a data-bs-toggle="modal" data-bs-target="#showCourseModal{{ $course->id }}"
                                                class="project-title">
                                                <div class="user-avatar sq bg-purple"><span> {{ $course->initials }}</span>
                                                </div>
                                                <div class="project-info">
                                                    <h6 class="title">{{ $course->name }}</h6><span
                                                        class="sub-text">{{ $course->trainer->first_name ?? 'Unassigned' }}</span>
                                                </div>
                                            </a>
                                            <div class="drodown"><a href="#"
                                                    class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 me-n1"
                                                    data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a data-bs-toggle="modal" data-bs-target="#showCourseModal{{ $course->id }}"><em
                                                                    class="icon ni ni-eye"></em><span>View
                                                                    Course</span></a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id }}"><em
                                                                    class="icon ni ni-edit"></em><span>Edit
                                                                    Course</span></a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#assignTrainerModal{{ $course->id }}"><em
                                                                    class="icon ni ni-check-round-cut"></em><span>Assign Trainer</span></a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#deleteCourseModal{{ $course->id }}">
                                                                <em class="icon ni ni-trash"></em><span>Delete
                                                                    Course</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="project-details">
                                            <p>{{ $course->description }}</p>
                                        </div>
                                        <div class="project-progress">
                                            <div class="project-progress-details">
                                                <div class="project-progress-task"><em
                                                        class="icon ni ni-check-round-cut"></em><span>{{ $course->modules ? $course->modules->count() : 0 }} Modules</span>
                                                </div>
                                                <div class="project-progress-percent">{{ $course->duration }} hrs</div>
                                            </div>
                                            <div class="progress progress-pill progress-md bg-light">
                                                <div class="progress-bar" data-progress="{{ $course->progress }}"></div>
                                            </div>
                                        </div>
                                        <div class="project-meta">
                                            <a href="{{ route('courses.modules.index', $course) }}"><span class="badge badge-dim bg-warning"><em
                                                        class="icon ni ni-eye"></em><span>view modules</span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($courses as $course)
<!-- Delete Modal -->
<div class="modal fade" id="deleteCourseModal{{ $course->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('courses.destroy', $course) }}">
            @csrf @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Course</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the course "{{ $course->name }}"?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@foreach ($courses as $course)
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
                        <select name="trainer_id" class="form-select" required>
                            <option value="">-- Choose Trainer --</option>
                            @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}" @if($course->trainer_id == $trainer->id) selected @endif>
                                {{ $trainer->first_name }} {{ $trainer->last_name }}
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
@endforeach
@foreach ($courses as $course)
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
                <strong>Trainer:</strong> {{ $course->trainer->first_name ?? 'Unassigned' }} {{ $course->trainer->last_name ?? '' }}<br>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($courses as $course)
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
                    <select name="trainer_id" class="form-select mb-2">
                        <option value="">-- Select Trainer (optional) --</option>
                        @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}">{{ $trainer->first_name }} {{ $trainer->last_name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection