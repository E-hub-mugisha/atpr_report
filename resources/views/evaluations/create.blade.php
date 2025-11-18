@extends('layouts.app')
@section('title', 'Evaluate Trainee')
@section('content')
<div class="container">

    <h3>Evaluate Trainee</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('evaluation.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label>Module</label>
                <select name="module_id" class="form-control">
                    @foreach($modules as $m)
                        <option value="{{ $m->id }}">{{ $m->module_code ?? '' }} - {{ $m->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label>Trainer</label>
                <select name="trainer_id" class="form-control">
                    @foreach($trainers as $t)
                        <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label>Student</label>
                <input name="student_id" class="form-control" value="{{ $student->id }}" readonly placeholder="{{ $student->full_name }}">
            </div>
        </div>

        <label>Competence Summary</label>
        <textarea name="competence" class="form-control mb-3"></textarea>

        <h4>Learning Outcomes</h4>

        <div id="learning-outcomes"></div>

        <button type="button" class="btn btn-secondary my-3" onclick="addOutcome()">+ Add Learning Outcome</button>

        <button type="submit" class="btn btn-primary">Submit Evaluation</button>
    </form>
</div>

<script>
let outcomeIndex = 0;

function addOutcome() {
    let html = `
    <div class="card p-3 mb-3">
        <label>Learning Outcome</label>
        <textarea name="learning_outcomes[${outcomeIndex}][description]" class="form-control mb-3"></textarea>

        <div class="criteria-${outcomeIndex}"></div>

        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addCriteria(${outcomeIndex})">
            + Add Performance Criterion
        </button>
    </div>
    `;
    document.getElementById('learning-outcomes').insertAdjacentHTML('beforeend', html);
    outcomeIndex++;
}

function addCriteria(outcomeId) {
    let container = document.querySelector('.criteria-' + outcomeId);
    let count = container.childElementCount;

    let html = `
    <div class="mb-2 d-flex gap-2">
        <input type="text" class="form-control mb-3" 
               name="learning_outcomes[${outcomeId}][criteria][${count}][description]"
               placeholder="Performance criterion">
        <input type="number" class="form-control mb-3" min="1" max="5"
               name="learning_outcomes[${outcomeId}][criteria][${count}][score]"
               placeholder="Score (optional)">
    </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>

@endsection
