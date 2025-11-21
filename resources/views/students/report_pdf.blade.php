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
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .no-border td {
            border: none !important;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            font-size: 17px;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            text-transform: uppercase;
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

    <!-- ======================= HEADER TOP ======================= -->
    <table>
        <tr>
            <!-- LEFT COLUMN -->
            <td style="width:35%; font-size:13px;">
                <strong>REPUBLIC OF RWANDA</strong><br>
                <strong>MINISTRY OF EDUCATION</strong><br>
                <strong>RWANDA TVET BOARD</strong><br>
                <strong>ATPR TRAINING CENTER</strong><br>
                Email: atpr.assosciation@gmail.com<br>
                Tel: 0788456039
            </td>

            <!-- CENTER LOGOS -->
            <td style="width:30%; text-align:center;">
                <table style="margin:auto;">
                    <tr>
                        <td style="padding:5px; text-align:center;">
                            <img src="data:image/png;base64,{{ $rtbLogo }}" width="120">
                        </td>
                        <td style="padding:5px; text-align:center;">
                            <img src="data:image/png;base64,{{ $atprLogo }}" width="120">
                        </td>
                    </tr>
                </table>
            </td>


            <!-- RIGHT COLUMN -->
            <td style="width:35%; font-size:13px;">
                <strong>ACADEMIC YEAR:</strong> {{ $student->academic_year }}<br>
                <strong>CLASS:</strong> INTAKE {{ $student->intake->month }}/{{ $student->intake->year }}<br>
                <strong>COURSE DURATION:</strong> 14 Weeks<br>
                <strong>TRAINEE NAME:</strong> {{ $student->full_name }}<br>
                <strong>Reg No:</strong> {{ $student->student_id }}
            </td>
        </tr>
    </table>

    <!-- ======================= CURRICULUM ROW ======================= -->
    <table>
        <tr>
            <td class="center bold" style="border-top:none;">
                CURRICULUM: INOZAMVUGA MU GUTWARA ABANTU KINYAMVUGA
            </td>
        </tr>
    </table>

    <!-- ======================= REPORT TITLE ======================= -->
    <div class="title">
        TRAINEE OVERALL ASSESSMENT REPORT
    </div>

    <!-- ======================= SECTOR / TRADE / RQF ======================= -->
    <table>
        <tr>
            <td><strong>SECTOR:</strong> TRANSPORT</td>
            <td><strong>QUALIFICATION TITLE:</strong> PROFESSIONAL PASSENGER DRIVER</td>
        </tr>
        <tr>
            <td><strong>TRADE:</strong> PASSENGER DRIVING</td>
            <td><strong>RQF LEVEL:</strong> 1</td>
        </tr>
    </table>

    <table style="width:100%; border-collapse:collapse; font-size:13px;">
        <tr>
            <td colspan="10" style="border:1px solid #000; padding:5px;"><strong>Behavior:</strong></td>
        </tr>

        <!-- HEADER ROWS -->
        <tr>
            <th rowspan="3" style="border:1px solid #000;">Module Code</th>
            <th rowspan="3" style="border:1px solid #000;">Module Title</th>
            <th rowspan="3" style="border:1px solid #000; text-align:center;">Module weight</th>
            <th colspan="4" style="border:1px solid #000; text-align:center;">MAX RESULTS</th>
            <th rowspan="3" style="border:1px solid #000; text-align:center;">Average</th>
            <th rowspan="3" style="border:1px solid #000; text-align:center;">Re-assessment (%)</th>
            <th rowspan="3" style="border:1px solid #000; text-align:center;">Decision</th>
        </tr>

        <tr>
            <th style="border:1px solid #000; text-align:center;">Formative Assessment</th>
            <th style="border:1px solid #000; text-align:center;">Ass. Comp (AI)</th>
            <th style="border:1px solid #000; text-align:center;">Ass. Comp (AII)</th>
            <th style="border:1px solid #000; text-align:center;">Total marks</th>
        </tr>

        <tr>
            <th style="border:1px solid #000; text-align:center;">50</th>
            <th style="border:1px solid #000; text-align:center;">50</th>
            <th style="border:1px solid #000; text-align:center;">100</th>
            <th style="border:1px solid #000; text-align:center;">100</th>
        </tr>
        @foreach($modules as $module)
        {{-- COMPLEMENTARY MODULES --}}
        @if($module->type == "complementary")

        {{-- Section Header (only once per complementary group) --}}
        @if(!isset($printedComplementary))
        @php $printedComplementary = true; @endphp
        <tr>
            <td colspan="10" style="background:#e6e6e6; font-weight:bold; border:1px solid #000;">
                COMPLEMENTARY MODULES
            </td>
        </tr>
        @endif

        @foreach($module->lessons as $lesson)
        @php $mark = $lesson->marks->first(); @endphp
        <tr>
            <td style="border:1px solid #000;">{{ $lesson->lesson_code }}</td>
            <td style="border:1px solid #000;">{{ $lesson->title }}</td>
            <td style="border:1px solid #000; text-align:center;"></td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->f_a ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">N/A</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->c_a ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->total ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->reass ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->obs ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->remarks ?? '-' }}</td>
        </tr>
        @endforeach

        {{-- CORE MODULES --}}
        @else

        <tr>
            <td colspan="10" style="background:#d9e6e8; font-weight:bold; text-align:center; border:1px solid #000;">
                CORE MODULES
            </td>
        </tr>

        {{-- MODULE TITLE --}}
        <tr>
            <td colspan="10" style="background:#e6e6e6; border:1px solid #000; font-weight:bold;">
                {{ $module->title }}
            </td>
        </tr>

        @foreach($module->lessons as $lesson)
        @php $mark = $lesson->marks->first(); @endphp
        <tr>
            <td style="border:1px solid #000;">{{ $lesson->lesson_code }}</td>
            <td style="border:1px solid #000;">{{ $lesson->title }}</td>
            <td style="border:1px solid #000; text-align:center;"></td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->f_a ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">N/A</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->c_a ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->total ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->reass ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->obs ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">{{ $mark->remarks ?? '-' }}</td>
        </tr>
        @endforeach

        @endif
        @endforeach


        <!-- TOTAL -->
        <tr>
            <td colspan="6" style="border:1px solid #000;"><strong>TOTAL:</strong></td>
            <td style="border:1px solid #000; text-align:center;"><strong>342.5</strong></td>
            <td colspan="3" style="border:1px solid #000;"></td>
        </tr>

        <!-- PERCENTAGE -->
        <tr>
            <td colspan="6" style="border:1px solid #000;"><strong>PERCENTAGE:</strong></td>
            <td style="border:1px solid #000; text-align:center;"><strong>38</strong></td>
            <td colspan="3" style="border:1px solid #000;"></td>
        </tr>

        <!-- POSITION -->
        <tr>
            <td colspan="10" style="border:1px solid #000;"><strong>POSITION</strong></td>
        </tr>

        <tr>
            <td colspan="10" style="border:1px solid #000;"><strong>Class Trainer’s Comments & signature:</strong></td>
        </tr>
    </table>

    <table border="1" cellspacing="0" cellpadding="6" style="border-collapse: collapse; width:100%;">
        <tr>
            <th style="width:200px;">Deliberation</th>
            <td></td>
        </tr>

        <tr>
            <td><strong>Promoted at 1st sitting</strong></td>
            <td></td>
        </tr>

        <tr>
            <td><strong>Reassessment required</strong></td>
            <td></td>
        </tr>

        <tr>
            <td><strong>Promoted after Re-assessment</strong></td>
            <td></td>
        </tr>

        <tr>
            <td><strong>Advised to Repeat</strong></td>
            <td></td>
        </tr>

        <tr>
            <td><strong>Dismissed</strong></td>
            <td></td>
        </tr>
    </table>


</body>

</html>