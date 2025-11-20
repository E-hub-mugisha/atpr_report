<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        table.report th,
        table.report td {
            border: 1px solid #000;
            padding: 4px;
        }

        .header-title {
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }

        .blue {
            background: #dae8fc;
        }

        .yellow {
            background: #fff2cc;
        }

        .gray {
            background: #e6e6e6;
        }

        .rotate {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
            font-weight: bold;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <table style="width:100%; border-collapse: collapse; text-align: center;">
        <tr>
            <td style="width:150px;">
                <img src="/mnt/data/bef7a7cf-bd23-4c0b-891b-cea58f601901.png" alt="RTB Logo" style="width:150px; height:auto;">
            </td>
            <td style="font-weight:bold; font-size:18px;">
                VERIFICATION FORM
            </td>
        </tr>
    </table>

    {{-- =================== SCHOOL, PROGRAM, CLASS =================== --}}
    <table class="report">
        <tr>
            <th class="header-title">SCHOOL DETAILS</th>
            <th class="header-title">SHORT COURSE PROGRAM DETAILS</th>
            <th class="header-title">CLASS DETAILS</th>
        </tr>

        <tr>
            <td><strong>School Name:</strong> {{ $school['name'] }}</td>
            <td><strong>Sector:</strong> {{ $program['sector'] }}</td>
            <td><strong>Class Teacher:</strong> {{ $program['teacher'] }}</td>
        </tr>

        <tr>
            <td><strong>Address:</strong> District: {{ $school['district'] }}, Sector: {{ $school['sector'] }}</td>
            <td><strong>Trade:</strong> {{ $program['trade'] }}</td>
            <td><strong>No of learners:</strong> {{ $program['learners'] }}</td>
        </tr>

        <tr>
            <td><strong>Head teacher:</strong> {{ $school['head_teacher'] }}</td>
            <td><strong>Program title:</strong> {{ $program['course'] }}</td>
            <td><strong>Total Teachers:</strong> {{ $program['teachers'] }}</td>
        </tr>

        <tr>
            <td><strong>School status:</strong> {{ $school['status'] }}</td>
            <td><strong>No of Modules:</strong> {{ $program['modules'] }}</td>
            <td><strong>Period:</strong> {{ $program['start_date'] }} to {{ $program['end_date'] }}</td>
        </tr>

        <tr>
            <td><strong>Tel Number:</strong> {{ $school['phone'] }}</td>
            <td><strong>Duration:</strong> {{ $program['duration'] }}</td>
            <td></td>
        </tr>

        <tr>
            <td><strong>E-mail:</strong> {{ $school['email'] }}</td>
            <td><strong>Accredited:</strong> Yes</td>
            <td></td>
        </tr>
    </table>

    <br>

    {{-- ======================== COMPETENCES TABLE ======================== --}}
    <table border="1" cellspacing="0" cellpadding="4">
        <thead>
            {{-- HEADER LEVEL 1 --}}
            <tr>
                <th rowspan="3" class="gray" style="width:35px">NO</th>
                <th rowspan="3" class="gray" style="width:180px">Trainee's names</th>
                <th rowspan="3" class="gray" style="width:80px">Availability of portfolio<br>(Yes / No)</th>

                <th colspan="{{ $modules->sum(fn($m) => $m->lessons->count()) }}" class="blue header-title">COMPETENCES TITLE</th>

                <th rowspan="3" class="rotate blue">Industrial attachment (%)</th>
                <th rowspan="3" class="rotate blue">FINAL INTEGRATED<br>ASSESSMENT (%)</th>
                <th rowspan="3" class="rotate blue">RESULTS</th>
                <th rowspan="3" class="rotate gray">DECISION (C / NYC)</th>
            </tr>

            {{-- HEADER LEVEL 2: Modules --}}
            <tr>
                @foreach($modules as $mod)
                <th colspan="{{ $mod->lessons->count() }}" class="{{ $loop->index < 3 ? 'yellow' : 'blue' }}">
                    {{ $mod->title }}
                </th>
                @endforeach
            </tr>

            {{-- HEADER LEVEL 3: Lessons --}}
            <tr>
                @foreach($modules as $mod)
                @foreach($mod->lessons as $lesson)
                <th class="{{ $loop->parent->index < 3 ? 'yellow' : 'blue' }}">
                    <div style="line-height:1.2;">
                        <span>{{ $lesson->lesson_code }}</span><br>
                        <strong>{{ $lesson->title }}</strong>
                    </div>
                </th>
                @endforeach
                @endforeach
            </tr>
        </thead>

        <tbody>
            {{-- TRAINEES --}}
            @foreach($students as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->full_name }}</td>
                <td>Yes</td>

                {{-- MARKS PER LESSON --}}
                @foreach($modules as $mod)
                @foreach($mod->lessons as $lesson)
                @php
                // Find mark for this lesson
                $mark = $t->marks->firstWhere('lesson_id', $lesson->id);
                @endphp
                <td style="text-align:center">
                    {{ $mark->total ?? 'N/A' }}
                </td>
                @endforeach
                @endforeach

                {{-- Industrial, Final, Results, Decision --}}
                <td style="text-align:center">{{ $t->industrial ?? 'N/A' }}</td>
                <td style="text-align:center">{{ $t->fia ?? 'N/A' }}</td>
                <td style="text-align:center">{{ $t->final ?? 'N/A' }}</td>
                <td style="text-align:center;font-weight:bold">{{ $t->decision ?? 'C' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- MAIN TRAINEE TABLE ENDS ABOVE --}}

    <br><br>

    {{-- OBSERVATION FROM EXTERNAL VERIFIERS --}}
    <table border="1" cellspacing="0" cellpadding="4" style="width:100%;">
        <tr>
            <td colspan="5">
                Observation from external verifiers:
                <br>
                The total number of trainees is 153. Out of these, 148 are competent and eligible for certification
            </td>
        </tr>
    </table>

    <br>

    {{-- INTERNAL VERIFIER --}}
    <table border="1" cellspacing="0" cellpadding="4" style="width:100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Names</th>
                <th>Position</th>
                <th>Phone</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>*</td>
                <td>ACP (Rtd) AHIMANA Anselme</td>
                <td>Head ATPR TC</td>
                <td>0788456099</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <br>

    {{-- EXTERNAL VERIFIERS --}}
    <table border="1" cellspacing="0" cellpadding="4" style="width:100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Verifier’s name</th>
                <th>Institution</th>
                <th>Position</th>
                <th>Phone</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>MINANI Callixte</td>
                <td>RTB</td>
                <td>Transport and Logistics Sector Specialist</td>
                <td>0788265200</td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>RENZAHO Jean Damascene</td>
                <td>RTB</td>
                <td>Youth Empowerment and Employment Promotion Specialist</td>
                <td>0788619071</td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>UWAMBAYE Rose</td>
                <td>RTB</td>
                <td>Administrative assistant to SPIU coordinator</td>
                <td>0788402090</td>
                <td></td>
            </tr>
        </tbody>
    </table>


</body>

</html>