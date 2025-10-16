@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Upload Trainee Assessment Excel</h2>

    <form action="{{ route('upload.excel') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="excel_file" class="form-label">Choose Excel File</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload & Extract</button>
    </form>
@endsection
