@extends('layouts.app')
@section('title', 'Student Management')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block nk-block-lg">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-primary mb-1"><em class="icon ni ni-student"></em> Student Management</h3>
                        <p class="text-muted mb-0">Manage student records, view details, and update information.</p>
                    </div>
                    <button class="btn btn-primary shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#createStudentModal">
                        <i class="bi bi-person-plus-fill me-1"></i> Add Student
                    </button>
                </div>

                <!-- Flash Message -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Table Header Description -->
                <div class="nk-block-head mb-3">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Student Records Table</h5>
                        <div class="nk-block-des">
                            <p class="text-muted small mb-0">
                                Below is the list of all registered students. You can add, edit, or remove records using the actions provided.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist"
                        data-auto-responsive="false">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col"><span class="sub-text">#</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Reg No</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Class</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Academic Year</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Intake</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Email</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Phone</span></th>
                                <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">{{ $loop->iteration }}</td>
                                <td class="nk-tb-col"><span class="badge bg-info text-dark">{{ $student->student_id }}</span></td>
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div
                                            class="user-avatar bg-dim-primary d-none d-sm-flex">
                                            <span>AB</span>
                                        </div>
                                        <div class="user-info"><span class="tb-lead">{{ $student->first_name }} {{ $student->last_name }}<span
                                                    class="dot dot-success d-md-none ms-1"></span></span><span>{{ $student->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">{{ $student->class }}</td>
                                <td class="nk-tb-col">{{ $student->academic_year }}</td>
                                <td class="nk-tb-col">{{ $student->intake_no }}/{{ $student->intake_year ?? '—' }}</td>
                                <td class="nk-tb-col">{{ $student->email }}</td>
                                <td class="nk-tb-col">{{ $student->phone }}</td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown"><a href="#"
                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-h"></em></a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><em
                                                                    class="icon ni ni-focus"></em><span>Quick
                                                                    View</span></a></li>
                                                        <li><a class="text-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                                                                <em class="icon ni ni-pencil"></em><span> Edit Student</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('student.marks.view', $student->id) }}">
                                                                <em class="icon ni ni-book-read"></em><span> View Marks</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->id }}">
                                                                <em class="icon ni ni-trash"></em><span> Delete Student</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
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
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" class="modal-content border-0 shadow-lg rounded-4">
                                        @csrf @method('DELETE')
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title fw-semibold"><i class="bi bi-trash3 me-1"></i> Delete Student</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-danger">Delete Student</button>
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
    </div>
</div>
</div>
<!-- Create Student Modal -->
<div class="modal fade" id="createStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('students.store') }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header">
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