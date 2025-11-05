@extends('layouts.app')
@section('title', 'Marks Management for ' . $module->title)
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block nk-block-lg mb-4">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-primary">
                            <em class="icon ni ni-student"></em>
                            Marks for Module: {{ $module->title }}
                        </h3>
                        <p class="text-muted mb-3">Manage student records, view details, and update information.</p>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-sm btn-outline-success rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadExcelModal">
                            📤 Upload Excel
                        </button>

                        <!-- Upload Excel Modal -->
                        <div class="modal fade" id="uploadExcelModal" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('modules.marks.import', $module) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
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
                                    </div>
                                </form>
                            </div>
                        </div>

                        <a href="{{ route('modules.marks.export', $module) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            📥 Export to Excel
                        </a>

                        <button class="btn btn-primary shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addStudentMarksModal">
                            <i class="bi bi-person-plus-fill me-1"></i> Add Student Marks
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

            <div class="card card-bordered card-preview mt-3">
                <div class="card-inner">
                    <table class="datatable-init nowrap nk-tb-list nk-tb-ulist"
                        data-auto-responsive="false">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col"><span class="sub-text">Trainee</span></th>
                                <th class="nk-tb-col"><span class="sub-text">IA</span></th>
                                <th class="nk-tb-col"><span class="sub-text">FA</span></th>
                                <th class="nk-tb-col"><span class="sub-text">CA</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Total</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Reass</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Obs</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Remarks</span></th>
                                <th class="nk-tb-col"><span class="sub-text">Updated</span></th>
                                <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marks as $mark)
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">{{ $mark->student->first_name }} {{ $mark->student->last_name }}</td>
                                <td class="nk-tb-col">{{ $mark->i_a }}</td>
                                <td class="nk-tb-col">{{ $mark->f_a }}</td>
                                <td class="nk-tb-col">{{ $mark->c_a }}</td>
                                <td class="nk-tb-col">{{ $mark->total }}</td>
                                <td class="nk-tb-col">{{ $mark->reass }}</td>
                                <td class="nk-tb-col">{{ $mark->obs }}</td>
                                <td class="nk-tb-col">{{ $mark->remarks }}</td>
                                <td class="nk-tb-col">{{ $mark->updated_at->diffForHumans() }}</td>
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
                                                        <li><a class="text-warning" data-bs-toggle="modal" data-bs-target="#editMarksModal{{ $mark->id }}">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($marks as $mark)
<!-- Edit Marks Modal -->
<div class="modal fade" id="editMarksModal{{ $mark->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('modules.marks.update', [$module, $mark]) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title fw-semibold"><i class="bi bi-pencil-square me-1"></i> Edit Student Marks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="trainee" class="form-control" value="{{ $mark->trainee }}" required>
                    </div>
                    <div class="col-md-1"><input type="number" name="i_a" class="form-control" value="{{ $mark->i_a }}"></div>
                    <div class="col-md-1"><input type="number" name="f_a" class="form-control" value="{{ $mark->f_a }}"></div>
                    <div class="col-md-1"><input type="number" name="c_a" class="form-control" value="{{ $mark->c_a }}"></div>
                    <div class="col-md-1"><input type="number" name="total" class="form-control" value="{{ $mark->total }}"></div>
                    <div class="col-md-1"><input type="number" name="reass" class="form-control" value="{{ $mark->reass }}"></div>
                    <div class="col-md-2"><input type="text" name="obs" class="form-control" value="{{ $mark->obs }}"></div>
                    <div class="col-md-2"><input type="text" name="remarks" class="form-control" value="{{ $mark->remarks }}"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success"><i class="bi bi-save me-1"></i> Update Marks</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@foreach ($marks as $mark)
<!-- Delete Marks Modal -->
<div class="modal fade" id="deleteMarksModal{{ $mark->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('modules.marks.destroy', [$module, $mark]) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title fw-semibold text-danger"><i class="bi bi-trash-fill me-1"></i> Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the marks record for <strong>{{ $mark->trainee }}</strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger"><i class="bi bi-trash me-1"></i> Delete Marks</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Add Student Marks Modal -->
<div class="modal fade" id="addStudentMarksModal" tabindex="-1" aria-labelledby="addStudentMarksModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('modules.marks.store', $module) }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header bg-light border-0 rounded-top-4">
                <h5 class="modal-title fw-bold text-primary" id="addStudentMarksModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i> Add Student Marks
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light-subtle">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Student Name</label>
                        <select name="student_id" class="form-select rounded-3" required>
                            <option value="" disabled selected>Select a student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Integrated Assessment (IA)</label>
                        <input type="number" name="i_a" class="form-control rounded-3" placeholder="Integrated Assessment (IA)">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Formative Assessment (FA)</label>
                        <input type="number" name="f_a" class="form-control rounded-3" placeholder="Formative Assessment (FA)">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Comprehensive assessment (CA)</label>
                        <input type="number" name="c_a" class="form-control rounded-3" placeholder="Comprehensive assessment (CA)">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Total</label>
                        <input type="number" name="total" class="form-control rounded-3" placeholder="Total">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Re-assessment (%)</label>
                        <input type="number" name="reass" class="form-control rounded-3" placeholder="Re-assessment (%)">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Observation</label>
                        <textarea type="text" name="obs" class="form-control rounded-3" placeholder="Observation (optional)"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Remarks</label>
                        <textarea type="text" name="remarks" class="form-control rounded-3" placeholder="Remarks (optional)"></textarea>
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

@endsection