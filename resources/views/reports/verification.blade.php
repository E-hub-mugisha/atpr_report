<style>
    table.report {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    table.report th, table.report td {
        border: 1px solid #000;
        padding: 4px;
        vertical-align: middle;
    }
    .header-title {
        background: #f2f2f2;
        font-weight: bold;
        text-align: center;
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
        white-space: nowrap;
        text-align: center;
        font-weight: bold;
    }
</style>

<table class="report">

    <!-- MAIN HEADERS -->
    <tr>
        <th class="header-title" colspan="1">SCHOOL DETAILS</th>
        <th class="header-title" colspan="1">SHORT COURSE PROGRAM DETAILS</th>
        <th class="header-title" colspan="1">CLASS DETAILS</th>
    </tr>

    <!-- ROWS -->
    <tr>
        <td><strong>School Name:</strong> ATPR</td>
        <td><strong>Sector:</strong> Transport</td>
        <td><strong>Class Teacher:</strong> SHEMA</td>
    </tr>

    <tr>
        <td><strong>Address:</strong> Nyarugenge</td>
        <td><strong>Sub-Sector/Trade:</strong> Muhima</td>
        <td><strong>No of learners:</strong> 153</td>
    </tr>

    <tr>
        <td><strong>Head teacher:</strong> AHIMANA</td>
        <td><strong>Short course program title:</strong> ITB</td>
        <td><strong>Total Teachers:</strong> 6</td>
    </tr>

    <tr>
        <td><strong>School status:</strong> PRIVATE</td>
        <td><strong>No of Modules:</strong> 6</td>
        <td><strong>Period:</strong> 21/10/2025</td>
    </tr>

    <tr>
        <td><strong>Tel Number:</strong> 0782390919</td>
        <td><strong>Duration:</strong> Three Month</td>
        <td></td>
    </tr>

    <tr>
        <td><strong>E-mail:</strong> kabosierik@gmail.com</td>
        <td></td>
        <td></td>
    </tr>

    <tr>
        <td><strong>School & Trade(s) accredited:</strong> yes</td>
        <td></td>
        <td></td>
    </tr>

</table>

<br>

<!-- COMPETENCES BIG TABLE -->
<table class="report">

    <!-- HEADER ROW -->
    <tr>
        <th rowspan="3" style="width:40px" class="gray">NO</th>
        <th rowspan="3" style="width:180px" class="gray">Trainee's names</th>
        <th rowspan="3" style="width:70px" class="gray">Availability of portfolio<br>(Yes / No)</th>

        <th colspan="9" class="header-title blue">COMPETENCES TITLE</th>

        <th rowspan="3" class="rotate blue">Industrial attachment (%)</th>
        <th rowspan="3" class="rotate blue">FINAL INTEGRATED ASSESSMENT (%)</th>
        <th rowspan="3" class="rotate blue">RESULTS</th>
        <th rowspan="3" class="rotate gray">DECISION (C / NYC)</th>
    </tr>

    <!-- SUB HEADER -->
    <tr>
        <th colspan="3" class="yellow">Complementary Modules (CCMs)</th>
        <th colspan="3" class="blue">GENERAL MODULES</th>
        <th colspan="3" class="blue">SPECIFIC MODULES</th>
    </tr>

    <!-- MODULE TITLES -->
    <tr>
        @foreach($modules as $index => $mod)
            <th class="{{ $index <= 2 ? 'yellow' : 'blue' }}">
                {{ $mod[0] }}<br><strong>{{ $mod[1] }}</strong>
            </th>
        @endforeach
    </tr>

    <!-- TRAINEE ROWS -->
    @foreach($students as $i => $t)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $t[0] }}</td>
            <td>{{ $t[1] }}</td>

            <!-- MODULE MARKS -->
            @foreach(array_slice($t, 2, 9) as $mk)
                <td style="text-align:center">{{ $mk }}</td>
            @endforeach

            <!-- INDUSTRIAL -->
            <td style="text-align:center">{{ $t[11] }}</td>

            <!-- FIA -->
            <td style="text-align:center">{{ $t[12] }}</td>

            <!-- FINAL SCORE -->
            <td style="text-align:center">{{ $t[13] }}</td>

            <!-- DECISION -->
            <td style="text-align:center; font-weight:bold">
                {{ $t[14] }}
            </td>
        </tr>
    @endforeach

</table>
