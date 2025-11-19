@extends('layouts.app')
@section('title', $lesson->title)
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <!-- Header Section -->
            <div class="nk-block nk-block-lg mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-primary">
                            <em class="icon ni ni-student"></em>
                            Marks for {{ $lesson->module->title }} Lesson: {{ $lesson->title }}
                        </h3>
                        <p class="text-muted mb-3">Manage student records, view details, and update information.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">

                        <!-- Upload Excel -->
                        <button class="btn btn-sm btn-outline-success rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadExcelModal">
                            📤 Upload Excel
                        </button>
                        <div class="modal fade" id="uploadExcelModal" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('lessons.marks.import', [$lesson->module_id, $lesson->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Upload Marks via Excel</h5>
                                    </div>
                                    <div class="modal-body">
                                        <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls" required>
                                        <small class="text-muted">Ensure your file has headers: trainee, i_a, f_a, c_a, total, reass, obs, remarks</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-success" type="submit">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Export Excel -->
                        <a href="{{ route('lessons.marks.export', [$lesson->module_id, $lesson->id]) }}" class="btn btn-outline-primary rounded-pill">Export</a>

                        <!-- Add Student Marks -->
                        <button class="btn btn-primary shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addStudentMarksModal">
                            <i class="bi bi-person-plus-fill me-1"></i> Add Student Marks
                        </button>
                        <button class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteAllMarksModal">
                            <i class="bi bi-trash-fill me-1"></i> Delete All Marks
                        </button>
                    </div>
                </div>

                <!-- Flash Message -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            </div>

            <!-- Marks Table -->
            <div class="card card-bordered card-preview mt-3">
                <div class="card-inner">
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col" title="Trainee full name">Trainee</th>
                                <th class="nk-tb-col" title="Formative Assessment">FA</th>
                                <th class="nk-tb-col" title="Comprehensive Assessment">CA</th>
                                <th class="nk-tb-col" title="Sum of FA + CA + reassessment">Total</th>
                                <th class="nk-tb-col" title="Re-assessment marks">Reass</th>
                                <th class="nk-tb-col" title="Observation - automatic comment based on total">Obs</th>
                                <th class="nk-tb-col" title="Remarks - automatic comment like Distinction, Pass, Fail">Remarks</th>
                                <th class="nk-tb-col" title="Decision: C = Competent, NYC = Not Yet Competent">Decision</th>
                                <th class="nk-tb-col" title="Reassessment Needed automatically calculated">Reassessment</th>
                                <th class="nk-tb-col" title="Last updated">Updated</th>
                                <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lessonmarks as $mark)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col" title="{{ $mark->student->first_name }} {{ $mark->student->last_name }}">
                                    {{ Str::limit($mark->student->first_name . ' ' . $mark->student->last_name, 20) }}
                                </td>
                                <td class="nk-tb-col">{{ $mark->f_a }}</td>
                                <td class="nk-tb-col">{{ $mark->c_a }}</td>
                                <td class="nk-tb-col">{{ $mark->total }}</td>
                                <td class="nk-tb-col">{{ $mark->reass }}</td>
                                <td class="nk-tb-col" title="{{ $mark->obs }}">{{ Str::limit($mark->obs, 20) }}</td>
                                <td class="nk-tb-col" title="{{ $mark->remarks }}">{{ Str::limit($mark->remarks, 20) }}</td>
                                <td class="nk-tb-col">
                                    @if($mark->decision == 'C')
                                    <span class="badge bg-success">C</span>
                                    @else
                                    <span class="badge bg-danger">NYC</span>
                                    @endif
                                </td>
                                <td class="nk-tb-col">
                                    @if($mark->reassessment_needed)
                                    <span class="badge bg-warning text-dark">Reassessment Needed</span>
                                    @else
                                    <span class="badge bg-success">No Reassessment</span>
                                    @endif
                                </td>
                                <td class="nk-tb-col">{{ $mark->updated_at->diffForHumans() }}</td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a class="text-warning" data-bs-toggle="modal" data-bs-target="#editMarksModal{{ $mark->id }}">
                                                                <em class="icon ni ni-pencil"></em><span> Edit mark</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteMarksModal{{ $mark->id }}">
                                                                <em class="icon ni ni-trash"></em><span> Delete mark</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    No marks records found for this lesson.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Add Student Marks Modal -->
<div class="modal fade" id="addStudentMarksModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('lessons.marks.storeComplementary', [$lesson->module_id, $lesson->id]) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header bg-light border-0 rounded-top-4">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="bi bi-person-plus-fill me-2"></i> Add Student Marks
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light-subtle">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Student Name</label>
                        <select name="student_id" class="form-select rounded-3" required>
                            <option value="" disabled selected>Select a student</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Formative Assessment (FA)</label>
                        <input type="number" name="f_a" class="form-control rounded-3" placeholder="Enter Formative Assessment">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Comprehensive Assessment (CA)</label>
                        <input type="number" name="c_a" class="form-control rounded-3" placeholder="Enter Comprehensive Assessment">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Re-assessment</label>
                        <input type="number" name="reass" class="form-control rounded-3" placeholder="Re-assessment Marks if any">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light rounded-bottom-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-save-fill me-1"></i> Save Marks
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Marks Modals -->
@foreach ($lessonmarks as $mark)
<div class="modal fade" id="editMarksModal{{ $mark->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('lessons.marks.update', [$lesson->module_id, $lesson->id, $mark->id]) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header bg-light border-0 rounded-top-4">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Student Marks
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light-subtle">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Student Name</label>
                        <select name="student_id" class="form-select rounded-3" required>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $mark->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Formative Assessment (FA)</label>
                        <input type="number" name="f_a" class="form-control rounded-3" value="{{ $mark->f_a }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Comprehensive Assessment (CA)</label>
                        <input type="number" name="c_a" class="form-control rounded-3" value="{{ $mark->c_a }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Re-assessment</label>
                        <input type="number" name="reass" class="form-control rounded-3" value="{{ $mark->reass }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light rounded-bottom-4">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Update Marks</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Delete Marks Modals -->
@foreach ($lessonmarks as $mark)
<div class="modal fade" id="deleteMarksModal{{ $mark->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('lessons.marks.destroy', $mark->id) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title fw-semibold text-danger"><i class="bi bi-trash-fill me-1"></i> Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete marks for <strong>{{ $mark->student->first_name }} {{ $mark->student->last_name }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger"><i class="bi bi-trash me-1"></i> Delete Marks</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Delete All Marks Modal -->
<div class="modal fade" id="deleteAllMarksModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('lessons.marks.deleteAll', [$lesson->module_id, $lesson->id]) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle me-1"></i> Confirm Delete All Marks</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="fw-semibold">
                    Are you sure you want to <strong>delete all marks</strong> for this lesson? This action cannot be undone.
                </p>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="confirmDeleteAll" required>
                    <label class="form-check-label" for="confirmDeleteAll">
                        Yes, I understand that all marks will be permanently deleted.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash-fill me-1"></i> Delete All Marks
                </button>
            </div>
        </form>
    </div>
</div>

@endsection