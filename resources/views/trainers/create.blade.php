{{-- resources/views/trainers/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Trainer Profile Form</h2>
    <form action="{{ route('trainers.store') }}" method="POST">
        @csrf

        {{-- Tabs navigation --}}
        <ul class="nav nav-tabs mb-4" id="trainerTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">Personal & School Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="qualifications-tab" data-bs-toggle="tab" data-bs-target="#qualifications" type="button" role="tab">Qualifications</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="trainings-tab" data-bs-toggle="tab" data-bs-target="#trainings" type="button" role="tab">Trainings</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="experiences-tab" data-bs-toggle="tab" data-bs-target="#experiences" type="button" role="tab">Experience</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="skills-tab" data-bs-toggle="tab" data-bs-target="#skills" type="button" role="tab">Skills & Proficiency</button>
            </li>
        </ul>

        <div class="tab-content" id="trainerTabContent">

            {{-- Personal & School Info --}}
            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Sex</label>
                        <select class="form-select" name="sex">
                            <option value="">Select</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Civil Status</label>
                        <select class="form-select" name="civil_status">
                            <option value="">Select</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widow/Widower">Widow/Widower</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                    <div class="col-md-4">
                        <label for="telephone" class="form-label">Telephone No</label>
                        <input type="text" class="form-control" id="telephone" name="telephone">
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="id_or_passport" class="form-label">ID No / Passport</label>
                        <input type="text" class="form-control" id="id_or_passport" name="id_or_passport">
                    </div>
                </div>

                <hr>
                <h5>School / Office Profile</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="school_name" class="form-label">School / Office Name</label>
                        <input type="text" class="form-control" id="school_name" name="school_name">
                    </div>
                    <div class="col-md-6">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" name="province">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="district" class="form-label">District</label>
                        <input type="text" class="form-control" id="district" name="district">
                    </div>
                    <div class="col-md-4">
                        <label for="sector" class="form-label">Sector</label>
                        <input type="text" class="form-control" id="sector" name="sector">
                    </div>
                    <div class="col-md-4">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-select" id="level" name="level">
                            <option value="">Select</option>
                            <option value="Polytechnic">Polytechnic</option>
                            <option value="TSS">TSS</option>
                            <option value="VTC">VTC</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Select</option>
                            <option value="Public">Public</option>
                            <option value="Government Aid">Government Aid</option>
                            <option value="Private">Private</option>
                        </select>
                    </div>
                </div>

                <hr>
                <h5>School / Office Manager</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="manager_name" class="form-label">Manager Name</label>
                        <input type="text" class="form-control" id="manager_name" name="manager_name">
                    </div>
                    <div class="col-md-4">
                        <label for="manager_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="manager_phone" name="manager_phone">
                    </div>
                    <div class="col-md-4">
                        <label for="manager_mobile" class="form-label">Mobile Phone</label>
                        <input type="text" class="form-control" id="manager_mobile" name="manager_mobile">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="manager_email" class="form-label">Email / Website</label>
                        <input type="text" class="form-control" id="manager_email" name="manager_email">
                    </div>
                </div>
            </div>

            {{-- Qualifications Tab --}}
            <div class="tab-pane fade" id="qualifications" role="tabpanel">
                <h5>Academic & Professional Qualifications</h5>
                <div id="academic-container">
                    <div class="academic-entry mb-3 border p-3 rounded">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Course / Qualification</label>
                                <input type="text" class="form-control" name="qualifications[0][course]">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Awarding Institution</label>
                                <input type="text" class="form-control" name="qualifications[0][institution]">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label class="form-label">Date Awarded</label>
                                <input type="month" class="form-control" name="qualifications[0][date_awarded]">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Evidence Attached</label>
                                <select class="form-select" name="qualifications[0][evidence]">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="add-academic">Add More Qualification</button>
            </div>

            {{-- Trainings Tab --}}
            <div class="tab-pane fade" id="trainings" role="tabpanel">
                <h5>Training Packages & Pedagogical / Technical / Cross-cutting Trainings</h5>
                <div class="mb-3">
                    <label class="form-label">Training Type / Description</label>
                    <textarea class="form-control" name="trainings[0][description]" rows="3"></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="trainings[0][status]">
                            <option value="Done">Done</option>
                            <option value="Not Done">Not Done</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No. of Hours</label>
                        <input type="number" class="form-control" name="trainings[0][hours]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Evidence Attached</label>
                        <select class="form-select" name="trainings[0][evidence]">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Experiences Tab --}}
            <div class="tab-pane fade" id="experiences" role="tabpanel">
                <h5>Work Experience & Industrial Attachments</h5>
                <div class="mb-3">
                    <label class="form-label">Position / Institution / Status</label>
                    <textarea class="form-control" name="experiences[0][details]" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration / Core Responsibilities</label>
                    <textarea class="form-control" name="experiences[0][duration_core]" rows="2"></textarea>
                </div>
            </div>

            {{-- Skills & Proficiency Tab --}}
            <div class="tab-pane fade" id="skills" role="tabpanel">
                <h5>Language Proficiency</h5>
                <div class="row mb-3">
                    @foreach(['English','French','Kinyarwanda','Swahili'] as $lang)
                        <div class="col-md-3 mb-2">
                            <label class="form-label">{{ $lang }}</label>
                            <input type="text" class="form-control" name="languages[{{ $lang }}]" placeholder="0-5">
                        </div>
                    @endforeach
                </div>

                <h5>Computer Skills</h5>
                <div class="row mb-3">
                    @foreach(['Internet','Word','Excel','PowerPoint'] as $skill)
                        <div class="col-md-3 mb-2">
                            <label class="form-label">{{ $skill }}</label>
                            <select class="form-select" name="computer_skills[{{ $skill }}]">
                                <option value="Poor">Poor</option>
                                <option value="Good">Good</option>
                                <option value="Very Good">Very Good</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Submit Trainer Profile</button>
        </div>
    </form>
</div>

{{-- JS for adding more qualifications --}}
@push('scripts')
<script>
    let academicIndex = 1;
    document.getElementById('add-academic').addEventListener('click', function() {
        let container = document.getElementById('academic-container');
        let entry = container.children[0].cloneNode(true);
        entry.querySelectorAll('input, select').forEach(input => input.value = '');
        entry.querySelectorAll('input, select').forEach(input => {
            let name = input.getAttribute('name');
            if(name) {
                input.setAttribute('name', name.replace(/\d+/, academicIndex));
            }
        });
        container.appendChild(entry);
        academicIndex++;
    });
</script>
@endpush

@endsection
