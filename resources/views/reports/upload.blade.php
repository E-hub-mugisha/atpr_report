@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Upload Trainee Assessment Report (Excel)</h2>
    <form action="{{ route('reports.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control mb-3" required>
        <button class="btn btn-primary">Upload & Extract</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</div>
@endsection
