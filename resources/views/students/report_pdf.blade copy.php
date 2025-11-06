<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $student->first_name }} {{ $student->last_name }} Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h2>Student Report</h2>
    <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
    <p><strong>Student ID:</strong> {{ $student->student_id }}</p>

    @foreach($modules as $module)
        <h3>Module: {{ $module->title }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Lesson</th>
                    <th>IA</th>
                    <th>FA</th>
                    <th>CA</th>
                    <th>Total</th>
                    <th>Re-assessment</th>
                    <th>Observation</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($module->lessons as $lesson)
                    @php $mark = $lesson->marks->first(); @endphp
                    <tr>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ $mark->i_a ?? '-' }}</td>
                        <td>{{ $mark->f_a ?? '-' }}</td>
                        <td>{{ $mark->c_a ?? '-' }}</td>
                        <td>{{ $mark->total ?? '-' }}</td>
                        <td>{{ $mark->reass ?? '-' }}</td>
                        <td>{{ $mark->obs ?? '-' }}</td>
                        <td>{{ $mark->remarks ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
