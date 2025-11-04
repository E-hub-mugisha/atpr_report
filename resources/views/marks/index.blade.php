@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Marks for Module: {{ $module->title }}</h3>

    <form method="POST" action="{{ route('modules.marks.store', $module) }}" class="row g-3 mb-4">
        @csrf
        <div class="col-md-3">
            <input type="text" name="trainee" class="form-control" placeholder="Trainee Name" required>
        </div>
        <div class="col-md-1"><input type="number" name="i_a" class="form-control" placeholder="IA"></div>
        <div class="col-md-1"><input type="number" name="f_a" class="form-control" placeholder="FA"></div>
        <div class="col-md-1"><input type="number" name="c_a" class="form-control" placeholder="CA"></div>
        <div class="col-md-1"><input type="number" name="total" class="form-control" placeholder="Total"></div>
        <div class="col-md-1"><input type="number" name="reass" class="form-control" placeholder="Reass"></div>
        <div class="col-md-2"><input type="text" name="obs" class="form-control" placeholder="Obs"></div>
        <div class="col-md-2"><input type="text" name="remarks" class="form-control" placeholder="Remarks"></div>
        <div class="col-md-12">
            <button class="btn btn-primary">Save Mark</button>
        </div>
    </form>
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

    <!-- Trigger Button -->
    <button class="btn btn-outline-success mb-3" data-bs-toggle="modal" data-bs-target="#uploadExcelModal">
        📤 Upload Excel
    </button>

    <a href="{{ route('modules.marks.export', $module) }}" class="btn btn-outline-primary mb-3">
        📥 Export to Excel
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Trainee</th>
                <th>IA</th>
                <th>FA</th>
                <th>CA</th>
                <th>Total</th>
                <th>Reass</th>
                <th>Obs</th>
                <th>Remarks</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marks as $mark)
            <tr>
                <td>{{ $mark->trainee }}</td>
                <td>{{ $mark->i_a }}</td>
                <td>{{ $mark->f_a }}</td>
                <td>{{ $mark->c_a }}</td>
                <td>{{ $mark->total }}</td>
                <td>{{ $mark->reass }}</td>
                <td>{{ $mark->obs }}</td>
                <td>{{ $mark->remarks }}</td>
                <td>{{ $mark->updated_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection