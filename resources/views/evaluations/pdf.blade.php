<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        td,
        th {
            padding: 6px;
            border: 1px solid #000;
            vertical-align: top;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 15px;
            margin-bottom: 4px;
        }

        .header-table td {
            border: none !important;
            padding: 2px !important;
        }

        .no-border td {
            border: none !important;
        }
    </style>
</head>

<body>

    <h3 style="text-align:center; text-transform:uppercase; margin-bottom:20px;">
        Trainee Competence Evaluation Report
    </h3>

    <table class="header-table" width="100%">
        <tr>
            <td width="33%">
                <strong>SECTOR:</strong> TRANSPORT<br>
                <strong>SUB-SECTOR/TRADE:</strong> PASSENGER DRIVING<br>
                <strong>LEVEL:</strong> 1<br>
                <strong>CERTIFICATE:</strong> ICYEMEZO CY’INOZAMWUGA MU GUTWARA ABANTU KINYAMWUGA
            </td>

            <td width="33%">
                <strong>Trainee's Detail</strong><br>
                <strong>Name:</strong> {{ $evaluation->student->full_name ?? '........' }}<br>
                <strong>Reg Nbr:</strong> {{ $evaluation->student->student_id ?? '........' }}
            </td>

            <td width="33%">
                <strong>Trainer's Detail</strong><br>
                <strong>Name:</strong> {{ $evaluation->trainer->first_name ?? '........' }}{{ $evaluation->trainer->last_name ?? '........' }}<br>
                <br>
                <strong>Additional Info</strong><br>
                <strong>ATPR T.C.</strong><br>
                <strong>INTAKE:</strong> {{ $evaluation->student->intake->month ?? '….' }}/{{ $evaluation->student->intake->year ?? '202….' }}
            </td>
        </tr>
    </table>

    <div class="section-title">Module Detail</div>
    <table>
        <tr>
            <td width="30%"><strong>MODULE (Code & Name):</strong></td>
            <td><strong>Code:</strong> {{ $evaluation->module->module_code ?? '……' }}</td>
            <td width="40%"><strong>Name:</strong> {{ $evaluation->module->title ?? '…….' }}</td>
        </tr>
        <tr>
            <td><strong>Length of Hours:</strong></td>
            <td>{{ $evaluation->hours ?? '….. Hrs' }}</td>
            <td>
                <strong>Duration/Date:</strong><br>
                From {{ optional($evaluation->student->intake)->start_date 
        ? \Carbon\Carbon::parse($evaluation->student->intake->start_date)->format('d/m/Y') 
        : '…./…/202….' }} 

to {{ optional($evaluation->student->intake)->end_date 
        ? \Carbon\Carbon::parse($evaluation->student->intake->end_date)->format('d/m/Y') 
        : '…./…/202….' }}

            </td>
        </tr>
    </table>

    <div class="section-title">COMPETENCE</div>
    <p>{{ $evaluation->competence ?? '…….' }}</p>

    <div class="section-title">LEARNING OUTCOME & PERFORMANCE CRITERIA</div>
    <table>
        <thead>
            <tr>
                <th width="25%">LEARNING OUTCOME</th>
                <th>PERFORMANCE CRITERIA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluation->learningOutcomes as $index => $outcome)
            <tr>
                <td><strong>{{ $index+1 }}.</strong> {{ $outcome->description }}</td>
                <td>
                    <ul style="margin:0; padding-left:15px;">
                        @foreach($outcome->performanceCriteria as $pcIndex => $pc)
                        <li>{{ ($index+1) .'.'. ($pcIndex+1) }} {{ $pc->description }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>