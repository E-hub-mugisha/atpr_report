@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Extracted Trainee Reports</h2>
    <a href="{{ route('reports.uploadForm') }}" class="btn btn-success mb-3">Upload New File</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Trainee Name</th>
                <th>Reg No</th>
                <th>Academic Year</th>
                <th>Class</th>
                <th>English</th>
                <th>Français</th>
                <th>Swahili</th>
                <th>Total</th>
                <th>Percentage</th>
                <th>Decision</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->trainee_name }}</td>
                    <td>{{ $report->reg_no }}</td>
                    <td>{{ $report->academic_year }}</td>
                    <td>{{ $report->class }}</td>
                    <td>{{ $report->english }}</td>
                    <td>{{ $report->francais }}</td>
                    <td>{{ $report->swahili }}</td>
                    <td>{{ $report->total_marks }}</td>
                    <td>{{ $report->percentage }}</td>
                    <td>{{ $report->decision }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
