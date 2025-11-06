@php 
    use App\Models\course;
    
    $course = course::all()->first();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainee Overall Assessment Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.2;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .header-table td {
            border: none;
            padding: 2px 4px;
        }

        .module-section {
            background-color: #d0d0d0;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td>
                REPUBLIC OF RWANDA<br>
                MINISTRY OF EDUCATION<br>
                RWANDA TVET BOARD<br>
                ATPR TRAINING CENTER<br>
                Email: atpr.association@gmail.com<br>
                Tel: 0788456099
            </td>

            <td style="text-align:right;">
                ACADEMIC YEAR: {{ $student->academic_year }} <br>
                CLASS: INTAKE {{ $student->intake_no }}/{{ $student->intake_year ?? '—' }} <br>
                COURSE DURATION: {{ $course->duration }} Weeks <br>
                TRAINEE NAME: {{ $student->first_name }} {{ $student->last_name }} <br>
                Reg N°: {{ $student->student_id }}
            </td>
        </tr>
    </table>

    <h2 style="text-align:center;">TRAINEE OVERALL ASSESSMENT REPORT</h2>
    <p style="text-align:center; font-weight:bold;">CURRICULUM: {{ $course->name }}</p>


    <!-- Main Info Table -->
    <table>
        <tr>
            <th>Sector</th>
            <th>Qualification Title</th>
            <th>RQF Level</th>
        </tr>
        <tr>
            <td>{{ $student->sector }}</td>
            <td>{{ $student->qualification_title }}</td>
            <td>{{ $student->rqf_level }}</td>
        </tr>
    </table>


    <!-- MODULES & LESSONS TABLE -->
    <table>
        <thead>
            <tr>
                <th>Module Code</th>
                <th>Module Title</th>
                <th>Module Weight</th>
                <th>FA</th>
                <th>IA</th>
                <th>CA</th>
                <th>Total</th>
                <th>%</th>
                <th>Re-assessment</th>
                <th>Decision</th>
            </tr>
        </thead>

        <tbody>

            @foreach($modules as $module)

            <!-- MODULE TITLE ROW -->
            <tr class="module-section">
                <td colspan="10">{{ $module->title }}</td>
            </tr>

            <!-- MODULE ROW WITH STUDENT MARKS -->
            @php
            $moduleMarks = $student->marks
            ->where('module_id', $module->id)
            ->first();
            @endphp

            <tr>
                <td>{{ $module->code }}</td>
                <td>{{ $module->title }}</td>
                <td>{{ $module->weight }}</td>

                <td>{{ $moduleMarks->f_a ?? 'N/A' }}</td>
                <td>{{ $moduleMarks->i_a ?? 'N/A' }}</td>
                <td>{{ $moduleMarks->c_a ?? 'N/A' }}</td>

                <td>{{ $moduleMarks->total ?? '' }}</td>
                <td>{{ $moduleMarks->percentage ?? '' }}</td>

                <td>{{ $moduleMarks->reass ?? '' }}</td>
                <td>{{ $moduleMarks->decision ?? '' }}</td>
            </tr>

            <!-- LESSONS INSIDE MODULE -->
            @foreach($module->lessons as $lesson)

            @php
            $lessonMark = $student->marks
            ->where('lesson_id', $lesson->id)
            ->first();
            @endphp

            <tr>
                <td colspan="2" style="padding-left:20px;">Lesson: {{ $lesson->title }}</td>

                <td>{{ $lesson->weight ?? '' }}</td>

                <td>{{ $lessonMark->f_a ?? 'N/A' }}</td>
                <td>{{ $lessonMark->i_a ?? 'N/A' }}</td>
                <td>{{ $lessonMark->c_a ?? 'N/A' }}</td>

                <td>{{ $lessonMark->total ?? '' }}</td>
                <td>{{ $lessonMark->percentage ?? '' }}</td>

                <td>{{ $lessonMark->reass ?? '' }}</td>
                <td>{{ $lessonMark->remarks ?? '' }}</td>
            </tr>

            @endforeach

            @endforeach


            <!-- TOTALS SECTION -->
            <tr>
                <td colspan="6" style="text-align:right;">TOTAL:</td>
                <td>{{ $student->total_marks }}</td>
                <td colspan="3">{{ $student->total_percentage }}%</td>
            </tr>

            <tr>
                <td colspan="6" style="text-align:right;">PERCENTAGE:</td>
                <td>{{ $student->total_percentage }}%</td>
                <td colspan="3"></td>
            </tr>

            <tr>
                <td colspan="6" style="text-align:right;">POSITION:</td>
                <td colspan="4">{{ $student->position }}</td>
            </tr>

        </tbody>
    </table>


    <!-- Footer Section -->
    <p>Class Trainer’s Comments & Signature:</p>
    <table>
        <tr>
            <td style="height:60px;"></td>
        </tr>
    </table>

    <table>
        <tr>
            <td>Deliberation</td>
            <td>Promoted at 1st sitting</td>
            <td>Reassessment required</td>
            <td>Promoted after Re-assessment</td>
            <td>Advised to Repeat</td>
            <td>Dismissed</td>
        </tr>
    </table>

</body>

</html>