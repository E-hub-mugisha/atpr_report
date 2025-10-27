@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Modules for {{ $course->name }}</h3>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModuleModal">➕ Add Module</button>

    @foreach ($modules as $module)
    <div class="card mb-2 shadow-sm">
        <div class="card-body">
            <h5>{{ $module->title }} <span class="badge bg-secondary">#{{ $module->order ?? '-' }}</span></h5>
            <p>{{ $module->description }}</p>

            <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#showModuleModal{{ $module->id }}">👁️ Show</button>
            <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $module->id }}">✏️ Edit</button>
            <form action="{{ route('courses.modules.destroy', [$course, $module]) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
            </form>
            <a href="{{ route('modules.marks.index', $module) }}" class="btn btn-sm btn-outline-primary">
                📝 View Marks
            </a>
        </div>
    </div>

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
</div>
@endsection