@extends('layouts.app')
@section('title', 'Student Management')

@section('content')
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-primary mb-1">
                        <em class="icon ni ni-users"></em> Student Management
                    </h3>
                    <p class="text-muted mb-0">Manage student profiles, intake details, and academic information.</p>
                </div>

                <button class="btn btn-primary rounded-pill shadow-sm"
                        data-bs-toggle="modal" data-bs-target="#createStudentModal">
                    <i class="bi bi-person-plus-fill me-1"></i> Add Student
                </button>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card card-bordered">
                <div class="card-inner">
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist">
                        <thead>
                            <tr class="nk-tb-head">
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Gender</th>
                                <th>Intake</th>
                                <th>Academic Year</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($students as $student)
                            <tr class="nk-tb-item">
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="badge bg-primary text-white">
                                        {{ $student->student_id }}
                                    </span>
                                </td>

                                <td>
                                    <div class="user-card">
                                        <div class="user-avatar bg-primary text-white">
                                            <span>{{ strtoupper(substr($student->first_name,0,1).substr($student->last_name,0,1)) }}</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="tb-lead">
                                                {{ $student->first_name }} {{ $student->last_name }}
                                            </span>
                                            <span>{{ $student->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $student->id_number }}</td>
                                <td>{{ $student->gender }}</td>

                                <td>
                                    {{ optional($student->intake)->intake_name ?? '—' }}
                                </td>

                                <td>{{ $student->academic_year }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>

                                <td class="nk-tb-col-tools text-end">
                                    <div class="dropdown">
                                        <a class="btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt">
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                                                        <em class="icon ni ni-edit"></em>
                                                        <span>Edit Student</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('student.marks.view', $student->id) }}">
                                                        <em class="icon ni ni-book-read"></em>
                                                        <span>View Marks</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="text-danger"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteStudentModal{{ $student->id }}">
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Delete</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Student Modal -->
                            <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <form method="POST" action="{{ route('students.update', $student) }}"
                                          class="modal-content rounded-4 shadow-lg">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title text-dark fw-bold">
                                                <i class="bi bi-pencil-square me-1"></i> Edit Student
                                            </h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <div class="col-md-4">
                                                    <label class="form-label">Student ID</label>
                                                    <input type="text" name="student_id" value="{{ $student->student_id }}" class="form-control">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">ID Number</label>
                                                    <input type="text" name="id_number" value="{{ $student->id_number }}" class="form-control">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Gender</label>
                                                    <select name="gender" class="form-select">
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" value="{{ $student->email }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" name="phone" value="{{ $student->phone }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Phone (Next of Kin)</label>
                                                    <input type="text" name="phone_next_of_kin" value="{{ $student->phone_next_of_kin }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Intake</label>
                                                    <select name="intake_id" class="form-select">
                                                        @foreach($intakes as $intake)
                                                        <option value="{{ $intake->id }}" 
                                                            {{ $student->intake_id == $intake->id ? 'selected' : '' }}>
                                                            {{ $intake->intake_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Academic Year</label>
                                                    <input type="text" name="academic_year" value="{{ $student->academic_year }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Qualification</label>
                                                    <input type="text" name="qualification_title" value="{{ $student->qualification_title }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Date of Birth</label>
                                                    <input type="date" name="dob" value="{{ $student->dob?->format('Y-m-d') }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" name="address" value="{{ $student->address }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Education Level</label>
                                                    <input type="text" name="education_level" value="{{ $student->education_level }}" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Marital Status</label>
                                                    <select name="marital_status" class="form-select">
                                                        <option>Single</option>
                                                        <option>Married</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Disability</label>
                                                    <input type="text" name="disability" value="{{ $student->disability }}" class="form-control">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-warning">Update Student</button>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteStudentModal{{ $student->id }}">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" 
                                          class="modal-content">
                                        @csrf
                                        @method('DELETE')

                                        <div class="modal-header bg-danger text-white">
                                            <h5><i class="bi bi-trash me-1"></i> Delete Student</h5>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete 
                                            <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>?
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">No students found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Student Modal -->
<div class="modal fade" id="createStudentModal">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('students.store') }}"
              class="modal-content rounded-4 shadow-lg">
            @csrf

            <div class="modal-header text-primary">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-person-plus me-2"></i>Add New Student
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Student ID</label>
                        <input type="text" name="student_id" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">ID Number</label>
                        <input type="text" name="id_number" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option>Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone (Next of Kin)</label>
                        <input type="text" name="phone_next_of_kin" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Intake</label>
                        <select name="intake_id" class="form-select">
                            @foreach($intakes as $intake)
                            <option value="{{ $intake->id }}">{{ $intake->month }}/{{ $intake->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Academic Year</label>
                        <input type="text" name="academic_year" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Qualification Title</label>
                        <input type="text" name="qualification_title" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Education Level</label>
                        <input type="text" name="education_level" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select">
                            <option>Single</option>
                            <option>Married</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label ">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Disability</label>
                        <!-- toggle switch -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="disability" value="1" id="disabilitySwitch">
                            <label class="form-check-label" for="disabilitySwitch">Has Disability</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success">Save Student</button>
            </div>
        </form>
    </div>
</div>
@endsection
