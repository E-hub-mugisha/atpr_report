@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary"><i class="bi bi-person-badge-fill me-2"></i> Trainers</h3>
            <p class="text-muted mb-0">Manage trainers, update information, and assign courses.</p>
        </div>
        <a href="{{ route('trainers.create') }}" class="btn btn-primary rounded-pill shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Trainer
        </a>
    </div>

    <div class="row g-3">
        @forelse ($trainers as $trainer)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-3">
                <h5 class="fw-bold">{{ $trainer->name }}</h5>
                <p class="text-muted mb-1"><i class="bi bi-envelope me-2"></i>{{ $trainer->email }}</p>
                <p class="text-muted mb-1"><i class="bi bi-telephone me-2"></i>{{ $trainer->phone }}</p>
                <p class="text-muted"><i class="bi bi-award me-2"></i>{{ $trainer->specialization }}</p>

                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-pill"
                        data-bs-toggle="modal" data-bs-target="#editTrainerModal{{ $trainer->id }}">
                        Edit
                    </button>

                    <form action="{{ route('trainers.destroy', $trainer) }}" method="POST"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm rounded-pill">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Trainer Modal -->
        <div class="modal fade" id="editTrainerModal{{ $trainer->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('trainers.update', $trainer) }}" method="POST"
                    class="modal-content border-0 shadow-lg rounded-4">
                    @csrf @method('PUT')

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-semibold">Edit Trainer</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control" value="{{ $trainer->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ $trainer->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input name="phone" class="form-control" value="{{ $trainer->phone }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Specialization</label>
                            <input name="specialization" class="form-control" value="{{ $trainer->specialization }}">
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-success rounded-pill"><i class="bi bi-save me-1"></i>Save Changes</button>
                    </div>

                </form>
            </div>
        </div>

        @empty
        <div class="col-12 text-center text-muted py-5">No trainers found.</div>
        @endforelse
    </div>
</div>

<!-- Add Trainer Modal -->
<div class="modal fade" id="addTrainerModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('trainers.store') }}"
            class="modal-content border-0 shadow-lg rounded-4">
            @csrf

            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold"><i class="bi bi-person-plus-fill me-1"></i> Add Trainer</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input name="first_name" class="form-control" placeholder="First Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input name="last_name" class="form-control" placeholder="Last Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="Email Address" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input name="phone" class="form-control" placeholder="Phone Number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Qualification</label>
                    <input name="qualification" class="form-control" placeholder="e.g., Web Development">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" placeholder="Tell us about the trainer"></textarea>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded-pill"><i class="bi bi-check2-circle me-1"></i> Save Trainer</button>
            </div>

        </form>
    </div>
</div>
@endsection
