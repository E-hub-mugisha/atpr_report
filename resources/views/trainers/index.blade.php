@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-primary mb-1">
                        <em class="icon ni ni-users"></em> Trainers List
                    </h3>
                    <p class="text-muted mb-0">Manage student profiles, intake details, and academic information.</p>
                </div>
                <a href="{{ route('trainers.create') }}" class="btn btn-primary mb-3">Add New Trainer</a>
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
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email / Phone</th>
                                <th>School / Office</th>
                                <th>Level / Status</th>
                                <th>Main Qualification</th>
                                <th>Languages</th>
                                <th>Computer Skills</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trainers as $trainer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trainer->first_name }} {{ $trainer->last_name }}</td>
                                <td>
                                    {{ $trainer->email }}<br>
                                    {{ $trainer->telephone }}
                                </td>
                                <td>
                                    {{ $trainer->school_name }}<br>
                                    {{ $trainer->province }}, {{ $trainer->district }}, {{ $trainer->sector }}
                                </td>
                                <td>{{ $trainer->level }} / {{ $trainer->status }}</td>
                                <td>
                                    @if($trainer->academicQualifications->isNotEmpty())
                                    {{ $trainer->academicQualifications->first()->qualification_name ?? $trainer->academicQualifications->first()->course ?? 'N/A' }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    @php
                                    $languages = $trainer->skillRatings->where('skill_type','language');
                                    @endphp
                                    @foreach($languages as $lang)
                                    {{ $lang->skill_name }}: {{ $lang->reading ?? 0 }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                    $computers = $trainer->skillRatings->where('skill_type','computer');
                                    @endphp
                                    @foreach($computers as $comp)
                                    {{ $comp->skill_name }}: {{ $comp->computer_level }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('trainers.show', $trainer->id) }}" class="btn btn-sm btn-info mb-1">View</a>
                                    <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if($trainers->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center">No trainers found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection