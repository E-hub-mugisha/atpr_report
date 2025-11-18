@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Trainer Evaluation Dashboard</h3>

    <div class="row g-3">
        @forelse($students as $student)
            <div class="col-md-4">
                <div class="card shadow-sm p-3 h-100">
                    <h5 class="card-title">{{ $student->full_name }}</h5>
                    <p class="card-text"><strong>Reg Number:</strong> {{ $student->student_id }}</p>
                    <p class="card-text"><strong>Sector:</strong> {{ $student->sector ?? 'N/A' }}</p>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('evaluations.show', $student->id) }}" class="btn btn-sm btn-primary">View Evaluations</a>
                        <a href="{{ route('evaluation.create', $student->id) }}" class="btn btn-sm btn-success">Add Evaluation</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No trainees found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
