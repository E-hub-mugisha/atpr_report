@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Assessment Summary</h2>

    <div class="card mb-4 p-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Name:</strong> {{ $traineeName }}</li>
            <li class="list-group-item"><strong>Qualification:</strong> {{ $qualification }}</li>
            <li class="list-group-item"><strong>Duration:</strong> {{ $courseDuration }}</li>
            <li class="list-group-item"><strong>Intake Year:</strong> {{ $intakeYear }}</li>
            <li class="list-group-item"><strong>Code:</strong> {{ $traineeCode }}</li>
        </ul>
    </div>

    <h3>Modules</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Score</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $module)
                <tr>
                    <td>{{ $module['code'] }}</td>
                    <td>{{ $module['title'] }}</td>
                    <td>{{ $module['score'] }}</td>
                    <td>{{ $module['remark'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
