<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        word-wrap: break-word;
        /* wrap long text */
        white-space: normal;
        /* allow wrapping */
        vertical-align: top;
        /* align text to top */
    }

    /* Fixed column widths for Student Table */
    .sn {
        width: 5%;
    }

    .school {
        width: 20%;
    }

    .trade {
        width: 20%;
    }

    .student {
        width: 20%;
    }

    .gender {
        width: 10%;
    }

    .training {
        width: 15%;
    }

    .months {
        width: 5%;
    }

    .start {
        width: 5%;
    }

    .end {
        width: 10%;
    }

    /* Fixed column widths for Competence Table */
    .no {
        width: 5%;
    }

    .competence-title {
        width: 40%;
    }

    .competence-code {
        width: 20%;
    }
</style>

<!-- General Info Table (starts in column B) -->
<table>
    <tr>
        <th>&nbsp;</th>
        <th></th>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><strong>District:</strong> Nyarugenge</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Sector:</strong> Muhima</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Intake:</strong> {{ $intake->month }}/{{ $intake->year }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Head Teachers'<br> phone number:<br></strong> 0788546099</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Date:</strong> {{ now()->format('d/m/Y') }}</td>
    </tr>
</table>

<br>

<!-- Student Table (starts in column B) -->
<table>
    <thead>
        <tr>
            <th class="sn">SN</th>
            <th class="school">School Name</th>
            <th class="trade">Trade</th>
            <th class="student">Student Names</th>
            <th class="gender">Gender</th>
            <th class="training">Training Type</th>
            <th class="months">Months</th>
            <th class="start">Start Date</th>
            <th class="end">End Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $student)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>Association Des Transporteurs <br>Des Personnes au Rwanda (ATPR TC)</td>
            <td>INOZAMWUGA MU GUTWARA <br>ABANTU MU BURYO BWA RUSANGE</td>
            <td>{{ $student->full_name }}</td>
            <td>{{ $student->gender }}</td>
            <td>IBT</td>
            <td>3 months</td>
            <td>10/22/2024</td>
            <td>01/25/2025</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<strong>N.B For each Trade</strong>

<!-- Competence Table (starts in column B) -->
<table>
    <thead>
        <tr>
            <th>&nbsp;</th> <!-- empty column A -->
            <th class="no">NO</th>
            <th class="competence-title">Competence Title</th>
            <th class="competence-code">Competence Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach($competences as $index => $lesson)
        <tr>
            <td>&nbsp;</td>
            <td>{{ $index + 1 }}</td>
            <td>
                {!! wordwrap($lesson->title, 30, "<br>", true) !!}
            </td>
            <td>{{ $lesson->lesson_code }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<!-- Signature Table (starts in column B) -->
<table>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Prepared by Trainer:<br></strong> {{ $trainerName }}</td>
        <td><strong>Verified by DOS:<br></strong> N/A</td>
        <td><strong>Approved by Head Teacher:<br></strong> ACP Rtd AHIMANA Anselme</td>
    </tr>
</table>