@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Trainer Profile Registration</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <h6 class="mb-2 fw-bold">❗ Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="progress mb-4" style="height: 8px;">
        <div id="progressBar" class="progress-bar bg-success" style="width: 20%;"></div>
    </div>

    <form id="trainerForm" action="{{ route('trainers.store') }}" method="POST" novalidate>
        @csrf

        {{-- STEP 1: Personal & School Info --}}
        <div id="step-1" class="step">
            <h5 class="mb-3">Personal Information</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Sex</label>
                    <select name="sex" class="form-select" required>
                        <option value="">Select</option>
                        <option>Female</option>
                        <option>Male</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Civil Status</label>
                    <select name="civil_status" class="form-select" required>
                        <option value="">Select</option>
                        <option>Single</option>
                        <option>Married</option>
                        <option>Divorced</option>
                        <option>Widow/Widower</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Telephone</label>
                    <input type="text" name="telephone" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">ID / Passport</label>
                    <input type="text" name="id_or_passport" class="form-control" required>
                </div>
            </div>

            <hr>
            <h5>School / Office Info</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">School / Office Name</label>
                    <input type="text" name="school_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Province</label>
                    <input type="text" name="province" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">District</label>
                    <input type="text" name="district" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sector</label>
                    <input type="text" name="sector" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Level</label>
                    <select name="school_level" class="form-select" required>
                        <option value="">Select</option>
                        <option value="polytechnic">Polytechnic</option>
                        <option value="tss">TSS</option>
                        <option value="vtc">VTC</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="school_status" class="form-select" required>
                        <option value="">Select</option>
                        <option value="public">Public</option>
                        <option value="government_aid">Government Aid</option>
                        <option value="private">Private</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- STEP 2: Qualifications --}}
        <div id="step-2" class="step d-none">
            <h5>Academic Qualifications</h5>
            <div id="academic-container">
                <div class="academic-entry border rounded p-3 mb-3">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Qualification Name</label>
                            <input type="text" class="form-control" name="qualifications[0][qualification_name]" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Institution</label>
                            <input type="text" class="form-control" name="qualifications[0][institution]" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Date Awarded</label>
                            <input type="date" class="form-control" name="qualifications[0][date_awarded]" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Level</label>
                            <input type="text" class="form-control" name="qualifications[0][level]">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Verification</label>
                            <select class="form-select" name="qualifications[0][verification]">
                                <option value="1">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button id="add-academic" type="button" class="btn btn-outline-secondary btn-sm">+ Add More</button>
        </div>

        {{-- STEP 3: Trainings --}}
        <div id="step-3" class="step d-none">
            <h5>Trainer Trainings</h5>
            <div id="training-container">
                <div class="training-entry border rounded p-3 mb-3">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Training Type</label>
                            <select class="form-select" name="trainings[0][type]" required>
                                <option value="">Select Training Type</option>
                                <option value="training_package">Training Package</option>
                                <option value="pedagogical">Pedagogical</option>
                                <option value="assessor">Assessor</option>
                                <option value="technical">Technical</option>
                                <option value="cross_cutting">Cross-Cutting</option>
                            </select>
                            <div class="invalid-feedback">Please select a training type.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Provider</label>
                            <input type="text" class="form-control" name="trainings[0][provider]">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hours</label>
                            <input type="number" class="form-control" name="trainings[0][hours]">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="trainings[0][status]">
                                <option>Certified</option>
                                <option>Not Certified</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Evidence</label>
                            <select class="form-select" name="trainings[0][evidence]">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button id="add-training" type="button" class="btn btn-outline-secondary btn-sm">+ Add More</button>
        </div>

        {{-- STEP 4: Experience --}}
        <div id="step-4" class="step d-none">
            <h5>Work Experience</h5>
            <div id="experience-container">
                <div class="experience-entry border rounded p-3 mb-3">
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Experience Type</label>
                            <select class="form-select" name="experiences[0][type]" required>
                                <option value="">Select Type</option>
                                <option value="work_experience">Work Experience</option>
                                <option value="industrial_attachment">Industrial Attachment</option>
                                <option value="delivery_assessment">Delivery / Assessment History</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="experiences[0][position]" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Institution</label>
                            <input type="text" class="form-control" name="experiences[0][institution]" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" name="experiences[0][status]">
                        </div>
                    </div>
                </div>
            </div>
            <button id="add-experience" type="button" class="btn btn-outline-secondary btn-sm">+ Add More</button>
        </div>

        {{-- STEP 5: Skills --}}
        <div id="step-5" class="step d-none">
            <h5>Language Proficiency</h5>
            <div class="row mb-3">
                @foreach(['English','French','Kinyarwanda','Swahili'] as $lang)
                <div class="col-md-3 mb-2">
                    <label>{{ $lang }}</label>
                    <input type="number" name="languages[{{ $lang }}]" min="0" max="5" class="form-control" required>
                </div>
                @endforeach
            </div>

            <h5>Computer Skills</h5>
            <div class="row">
                @foreach(['Internet','Word','Excel','PowerPoint'] as $skill)
                <div class="col-md-3 mb-2">
                    <label>{{ $skill }}</label>
                    <select class="form-select" name="computer_skills[{{ $skill }}]" required>
                        <option value="">Select</option>
                        <option value="poor">Poor</option>
                        <option value="good">Good</option>
                        <option value="very_good">Very Good</option>
                    </select>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <button type="button" id="prevBtn" class="btn btn-outline-secondary">Previous</button>
            <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
        </div>
    </form>
</div>

<style>
    .was-validated input:invalid,
    .was-validated select:invalid,
    .was-validated textarea:invalid {
        border-color: #dc3545 !important;
    }

    .was-validated input:valid,
    .was-validated select:valid,
    .was-validated textarea:valid {
        border-color: #28a745 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const totalSteps = 5;
        const form = document.getElementById('trainerForm');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const progressBar = document.getElementById('progressBar');

        function showStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
            document.getElementById(`step-${step}`).classList.remove('d-none');
            progressBar.style.width = `${(step / totalSteps) * 100}%`;
            prevBtn.disabled = (step === 1);
            nextBtn.textContent = (step === totalSteps) ? 'Submit' : 'Next';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function validateStep(step) {
            const stepElement = document.getElementById(`step-${step}`);
            const inputs = stepElement.querySelectorAll('input, select, textarea');
            let valid = true;
            stepElement.classList.add('was-validated');
            inputs.forEach(i => {
                if (!i.checkValidity()) valid = false;
            });
            return valid;
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < totalSteps) {
                if (validateStep(currentStep)) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else {
                if (form.checkValidity()) form.submit();
                else validateStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        function addDynamicSection(buttonId, containerId) {
            const button = document.getElementById(buttonId);
            let index = 1;
            button.addEventListener('click', () => {
                const container = document.getElementById(containerId);
                const clone = container.firstElementChild.cloneNode(true);
                clone.querySelectorAll('input, select').forEach(input => {
                    input.value = '';
                    input.name = input.name.replace(/\d+/, index);
                });
                container.appendChild(clone);
                index++;
            });
        }

        addDynamicSection('add-academic', 'academic-container');
        addDynamicSection('add-training', 'training-container');
        addDynamicSection('add-experience', 'experience-container');

        showStep(currentStep);
    });
</script>
@endsection