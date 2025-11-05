@extends('layouts.app')
@section('title', 'Modules for ' . $course->name)
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Modules for {{ $course->name }}</h3>
                        <div class="nk-block-des text-soft">
                            <p>You have total {{ $modules->count() }} modules.</p>
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
                                            class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal"><em
                                                class="icon ni ni-plus"></em><span>Add
                                                Module</span></a></li>
                                    <li class="nk-block-tools-opt d-block d-sm-none">
                                        <a href="#" class="btn btn-icon btn-primary">
                                            <em class="icon ni ni-plus"></em>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="row g-gs">
                        @foreach ($modules as $module)
                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                            <div class="card card-bordered h-100">
                                <div class="card-inner">
                                    <div class="project">
                                        <div class="project-head"><a data-bs-toggle="modal" data-bs-target="#showModuleModal{{ $module->id }}"
                                                class="project-title">
                                                <div class="user-avatar sq bg-purple"><span> {{ $module->order ?? '-' }}</span>
                                                </div>
                                                <div class="project-info">
                                                    <h6 class="title">{{ $module->title }}</h6><span
                                                        class="sub-text">{{ $module->trainer ?? 'Unassigned' }}</span>
                                                </div>
                                            </a>
                                            <div class="drodown"><a href="#"
                                                    class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 me-n1"
                                                    data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a data-bs-toggle="modal" data-bs-target="#showModuleModal{{ $module->id }}"><em
                                                                    class="icon ni ni-eye"></em><span>View
                                                                    Module</span></a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $module->id }}"><em
                                                                    class="icon ni ni-edit"></em><span>Edit
                                                                    Module</span></a></li>
                                                        <li><a href="{{ route('modules.marks.index', $module) }}"><em
                                                                    class="icon ni ni-check-round-cut"></em><span>Students Marks</span></a></li>
                                                        <li><a data-bs-toggle="modal" data-bs-target="#deleteModuleModal{{ $module->id }}">
                                                                <em class="icon ni ni-trash"></em><span>Delete
                                                                    Module</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="project-details">
                                            <p>{{ $module->description }}</p>
                                        </div>
                                        <div class="project-progress">
                                            <div class="project-progress-details">
                                                <div class="project-progress-task"><em
                                                        class="icon ni ni-check-round-cut"></em><span>{{ $module->course ? $module->course->modules->count() : 0 }} Modules</span>
                                                </div>
                                                <div class="project-progress-percent">{{ $module->duration }} hrs</div>
                                            </div>
                                            <div class="progress progress-pill progress-md bg-light">
                                                <div class="progress-bar" data-progress="{{ $module->progress }}"></div>
                                            </div>
                                        </div>
                                        <div class="project-meta">
                                            <a href="{{ route('modules.marks.index', $module) }}"><span class="badge badge-dim bg-success"><em
                                                        class="icon ni ni-eye"></em><span>view student marks</span></span></a>
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
@foreach ($modules as $module)
<!-- Delete Modal -->
<div class="modal fade" id="deleteModuleModal{{ $module->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('courses.modules.destroy', [$course, $module]) }}">
            @csrf @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Module</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the module "{{ $module->title }}"?</p>
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
@foreach ($modules as $module)
<!-- Show Modal -->
<div class="modal fade" id="showModuleModal{{ $module->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Module Details</h5>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> {{ $module->title }}</p>
                <p><strong>Description:</strong> {{ $module->description }}</p>
                <p><strong>Order:</strong> {{ $module->order ?? '-' }}</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($modules as $module)
<!-- Edit Modal -->
<div class="modal fade" id="editModuleModal{{ $module->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('courses.modules.update', [$course, $module]) }}">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Module</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="title" value="{{ $module->title }}" class="form-control mb-2" required>
                    <textarea name="description" class="form-control mb-2">{{ $module->description }}</textarea>
                    <input type="number" name="order" value="{{ $module->order }}" class="form-control mb-2">
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
<div class="modal fade" id="addModuleModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('courses.modules.store', $course) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Module</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="title" class="form-control mb-2" placeholder="Module Title" required>
                    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                    <input type="number" name="order" class="form-control mb-2" placeholder="Order">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Add Module</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection