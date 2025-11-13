{{-- resources/views/trainers/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Trainer Profile: {{ $trainer->first_name }} {{ $trainer->last_name }}</h2>

    {{-- Personal & School Info --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Personal & School Info
        </div>
        <div class="card-body">
            <h5>Personal Info</h5>
            <p><strong>Sex:</strong> {{ $trainer->sex }}</p>
            <p><strong>Civil Status:</strong> {{ $trainer->civil_status }}</p>
            <p><strong>Date of Birth:</strong> {{ $trainer->dob ? $trainer->dob->format('d-m-Y') : '-' }}</p>
            <p><strong>Telephone:</strong> {{ $trainer->telephone }}</p>
            <p><strong>Email:</strong> {{ $trainer->email }}</p>
            <p><strong>ID / Passport:</strong> {{ $trainer->id_or_passport }}</p>

            <hr>
            <h5>School / Office</h5>
            <p><strong>Name:</strong> {{ $trainer->school_name }}</p>
            <p><strong>Province:</strong> {{ $trainer->province }}</p>
            <p><strong>District:</strong> {{ $trainer->district }}</p>
            <p><strong>Sector:</strong> {{ $trainer->sector }}</p>
            <p><strong>Level:</strong> {{ $trainer->level }}</p>
            <p><strong>Status:</strong> {{ $trainer->status }}</p>

            <hr>
            <h5>Manager Info</h5>
            <p><strong>Name:</strong> {{ $trainer->manager_name }}</p>
            <p><strong>Phone:</strong> {{ $trainer->manager_phone }}</p>
            <p><strong>Mobile:</strong> {{ $trainer->manager_mobile }}</p>
            <p><strong>Email / Website:</strong> {{ $trainer->manager_email }}</p>
        </div>
    </div>

    {{-- Academic Qualifications --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Academic & Professional Qualifications
        </div>
        <div class="card-body">
            @if($trainer->academicQualifications->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Qualification</th>
                            <th>Institution</th>
                            <th>Date Awarded</th>
                            <th>Level</th>
                            <th>Verified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainer->academicQualifications as $qual)
                            <tr>
                                <td>{{ $qual->qualification_name }}</td>
                                <td>{{ $qual->institution }}</td>
                                <td>{{ $qual->date_awarded ? \Carbon\Carbon::parse($qual->date_awarded)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $qual->level }}</td>
                                <td>{{ $qual->verification ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No qualifications recorded.</p>
            @endif
        </div>
    </div>

    {{-- Trainings --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            Trainings
        </div>
        <div class="card-body">
            @if($trainer->trainings->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Hours</th>
                            <th>Evidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainer->trainings as $training)
                            <tr>
                                <td>{{ ucfirst(str_replace('_',' ', $training->type)) }}</td>
                                <td>{{ $training->description ?? $training->title }}</td>
                                <td>{{ $training->status }}</td>
                                <td>{{ $training->hours ?? '-' }}</td>
                                <td>{{ $training->evidence ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No trainings recorded.</p>
            @endif
        </div>
    </div>

    {{-- Experiences --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            Work Experience & Industrial Attachments
        </div>
        <div class="card-body">
            @if($trainer->experiences->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Position</th>
                            <th>Institution</th>
                            <th>Status</th>
                            <th>Sector / Trade</th>
                            <th>Core Responsibility</th>
                            <th>Duration</th>
                            <th>Evidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainer->experiences as $exp)
                            <tr>
                                <td>{{ ucfirst(str_replace('_',' ', $exp->type)) }}</td>
                                <td>{{ $exp->position }}</td>
                                <td>{{ $exp->institution }}</td>
                                <td>{{ $exp->status }}</td>
                                <td>{{ $exp->sector }} / {{ $exp->trade }}</td>
                                <td>{{ $exp->core_responsibility }}</td>
                                <td>
                                    @if($exp->from_date && $exp->to_date)
                                        {{ \Carbon\Carbon::parse($exp->from_date)->format('d-m-Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($exp->to_date)->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $exp->evidence ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No experiences recorded.</p>
            @endif
        </div>
    </div>

    {{-- Skills --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            Skills & Proficiency
        </div>
        <div class="card-body">
            <h5>Language Proficiency</h5>
            @if($trainer->skillRatings->where('skill_type','language')->count())
                <ul class="list-group mb-3">
                    @foreach($trainer->skillRatings->where('skill_type','language') as $lang)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $lang->skill_name }}
                            <span>Reading: {{ $lang->reading ?? '-' }}, Speaking: {{ $lang->speaking ?? '-' }}, Writing: {{ $lang->writing ?? '-' }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No language skills recorded.</p>
            @endif

            <h5>Computer Skills</h5>
            @if($trainer->skillRatings->where('skill_type','computer')->count())
                <ul class="list-group">
                    @foreach($trainer->skillRatings->where('skill_type','computer') as $comp)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $comp->skill_name }} - Level: {{ $comp->computer_level }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No computer skills recorded.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('trainers.index') }}" class="btn btn-outline-primary">Back to Trainer List</a>
</div>
@endsection
