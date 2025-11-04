@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">🎓 Student Management</h3>
        <button class="btn btn-primary shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#createStudentModal">
            <i class="bi bi-person-plus-fill me-1"></i> Add Student
        </button>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Student Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary fw-semibold">
                    <tr>
                        <th>#</th>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Academic Year</th>
                        <th>Intake</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-info text-dark">{{ $student->student_id }}</span></td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->academic_year }}</td>
                            <td>{{ $student->intake_no }}/{{ $student->intake_year ?? '—' }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form method="POST" action="{{ route('students.update', $student) }}" class="modal-content border-0 shadow-lg rounded-4">
                                    @csrf @method('PUT')
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title fw-semibold"><i class="bi bi-pencil-square me-1"></i> Edit Student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Student ID</label>
                                                <input type="text" name="student_id" value="{{ $student->student_id }}" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">First Name</label>
                                                <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" value="{{ $student->email }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="phone" value="{{ $student->phone }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Gender</label>
                                                <select name="gender" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Intake</label>
                                                <input type="text" name="intake" value="{{ $student->intake }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Academic Year</label>
                                                <input type="text" name="academic_year" value="{{ $student->academic_year }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" name="dob" value="{{ $student->dob }}" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Address</label>
                                                <input type="text" name="address" value="{{ $student->address }}" class="form-control">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Qualification Title</label>
                                                <input type="text" name="qualification_title" value="{{ $student->qualification_title }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-warning text-dark">Update Student</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Student Modal -->
<div class="modal fade" id="createStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('students.store') }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold"><i class="bi bi-person-plus-fill me-1"></i> Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Student ID</label>
                        <input type="text" name="student_id" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Intake</label>
                        <input type="text" name="intake_no" class="form-control" placeholder="e.g. 01/24">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Intake Year</label>
                        <input type="text" name="intake_year" class="form-control" placeholder="e.g. 01/24">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Academic Year</label>
                        <input type="text" name="academic_year" class="form-control" placeholder="2024/2025">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Qualification Title</label>
                        <input type="text" name="qualification_title" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success"><i class="bi bi-save me-1"></i> Save Student</button>
            </div>
        </form>
    </div>
</div>
@endsection
