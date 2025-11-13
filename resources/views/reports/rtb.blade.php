@extends('layouts.app')
@section('title', 'Reports Center')

@section('content')
<div class="container py-5">

    <h2 class="fw-bold mb-4 text-primary">
        <i class="bi bi-file-earmark-bar-graph me-2"></i>
        Reports Center
    </h2>

    <p class="text-muted mb-4">Generate reports based on intakes and student performance.</p>

    <div class="row g-4">

        <!-- ✅ CARD 1: Competent Students -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-3">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <h4 class="fw-bold">Competent Students</h4>
                    <p class="text-muted">Generate list of competent trainees for a selected intake.</p>

                    <button class="btn btn-success rounded-pill px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#competentModal">
                        Generate
                    </button>
                </div>
            </div>
        </div>

        <!-- ✅ CARD 2: Student Information -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-3">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <h4 class="fw-bold">Student Information</h4>
                    <p class="text-muted">Generate a list containing full student details.</p>

                    <button class="btn btn-primary rounded-pill px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#studentInfoModal">
                        Generate
                    </button>
                </div>
            </div>
        </div>

        <!-- ✅ CARD 3: Final Report -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-danger mb-3">
                        <i class="bi bi-clipboard-data-fill"></i>
                    </div>

                    <h4 class="fw-bold">Final Results Report</h4>
                    <p class="text-muted">Generate final summary for all students and their marks.</p>

                    <button class="btn btn-danger rounded-pill px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#finalReportModal">
                        Generate
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- ✅ MODAL 1: Competent Students -->
<div class="modal fade" id="competentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="GET" action="{{ route('reports.competent') }}" class="modal-content rounded-4 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Select Intake</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label fw-semibold">Choose Intake</label>
                <select name="intake" class="form-select rounded-3" required>
                    <option value="" selected disabled>Select intake</option>
                    @foreach($intakes as $intake)
                        <option value="{{ $intake }}">{{ $intake }}</option>
                    @endforeach
                </select>

                <label class="form-label fw-semibold">Choose Format</label>
                <select name="format" class="form-select rounded-3" required>
                    <option value="" selected disabled>Select file format</option>
                    <option value="pdf">PDF</option>
                    <option value="csv">Excel</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded-pill px-4">Generate</button>
            </div>
        </form>
    </div>
</div>


<!-- ✅ MODAL 2: Student Information -->
<div class="modal fade" id="studentInfoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="GET" action="{{ route('reports.students') }}" class="modal-content rounded-4 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Select Intake</h5>
                <button type="button" class="btn-close"></button>
            </div>

            <div class="modal-body">
                <label class="form-label fw-semibold">Choose Intake</label>
                <select name="intake" class="form-select rounded-3" required>
                    <option value="" selected disabled>Select intake</option>
                    @foreach($intakes as $intake)
                        <option value="{{ $intake }}">{{ $intake }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-pill px-4">Generate</button>
            </div>
        </form>
    </div>
</div>


<!-- ✅ MODAL 3: Final Report -->
<div class="modal fade" id="finalReportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="GET" action="{{ route('reports.final') }}" class="modal-content rounded-4 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Select Intake</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label fw-semibold">Choose Intake</label>
                <select name="intake" class="form-select rounded-3" required>
                    <option value="" selected disabled>Select intake</option>
                    @foreach($intakes as $intake)
                        <option value="{{ $intake }}">{{ $intake }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger rounded-pill px-4">Generate</button>
            </div>
        </form>
    </div>
</div>

@endsection
