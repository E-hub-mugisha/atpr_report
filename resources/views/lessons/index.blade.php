@extends('layouts.app')
@section('title', 'Lessons for ' . $module->title)

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">
                <i class="bi bi-journal-text me-2"></i>
                Lessons for Module: {{ $module->title }}
            </h3>
            <p class="text-muted mb-0">Manage lessons, update content and maintain lesson order.</p>
        </div>

        <button class="btn btn-primary rounded-pill shadow-sm px-4"
            data-bs-toggle="modal"
            data-bs-target="#addLessonModal">
            <i class="bi bi-plus-lg me-1"></i> Add Lesson
        </button>
    </div>

    <!-- Lessons Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Lesson Code</th>
                        <th>Lesson Title</th>
                        <th>Content</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($module->lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td class="fw-semibold">{{ $lesson->lesson_code }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ $lesson->content ?? '-' }}</td>
                        <td>{{ $lesson->created_at->diffForHumans() }}</td>
                        <td class="text-end">

                            <button class="btn btn-sm btn-outline-primary rounded-pill"
                                data-bs-toggle="modal"
                                data-bs-target="#editLessonModal{{ $lesson->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger rounded-pill"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteLessonModal{{ $lesson->id }}">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-folder-x fs-3 d-block"></i>
                            No lessons added yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>


<!-- ✅ Add Lesson Modal -->
<div class="modal fade" id="addLessonModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST"
            action="{{ route('modules.lessons.store', $module) }}"
            class="modal-content border-0 shadow-lg rounded-4">

            @csrf

            <div class="modal-header bg-light border-0 rounded-top-4">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="bi bi-plus-circle me-2"></i> Add New Lesson
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light-subtle">
                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Lesson Title</label>
                        <input type="text" name="title" class="form-control rounded-3" placeholder="Enter lesson title" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Lesson Code</label>
                        <input type="text" name="lesson_code" class="form-control rounded-3" placeholder="Enter lesson code" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Content (optional)</label>
                        <textarea name="content" rows="3" class="form-control rounded-3" placeholder="Short content..."></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer bg-light border-0 rounded-bottom-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-1"></i> Save Lesson
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ✅ Edit & Delete Modals for Each Lesson -->
@foreach($module->lessons as $lesson)

<!-- Edit Lesson Modal -->
<div class="modal fade" id="editLessonModal{{ $lesson->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST"
            action="{{ route('modules.lessons.update', [$module, $lesson]) }}"
            class="modal-content border-0 shadow-lg rounded-4">

            @csrf
            @method('PUT')

            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="bi bi-pencil-square me-2"></i> Edit Lesson
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light-subtle">
                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Lesson Title</label>
                        <input type="text" name="title" class="form-control rounded-3" value="{{ $lesson->title }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Content</label>
                        <textarea name="content" rows="3" class="form-control rounded-3">{{ $lesson->content }}</textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-save"></i> Update Lesson
                </button>
            </div>

        </form>
    </div>
</div>


<!-- Delete Lesson Modal -->
<div class="modal fade" id="deleteLessonModal{{ $lesson->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST"
            action="{{ route('modules.lessons.destroy', [$module, $lesson]) }}"
            class="modal-content border-0 shadow-lg rounded-4">

            @csrf
            @method('DELETE')

            <div class="modal-header bg-light border-0">
                <h5 class="modal-title text-danger fw-bold">
                    <i class="bi bi-trash-fill me-2"></i> Delete Lesson
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">
                    Are you sure you want to delete
                    <strong class="text-primary">{{ $lesson->title }}</strong>?
                    <br>This action cannot be undone.
                </p>
            </div>

            <div class="modal-footer bg-light border-0">
                <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>

        </form>
    </div>
</div>

@endforeach

@endsection