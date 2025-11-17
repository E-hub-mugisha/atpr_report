<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    th,
    td {
        border: 1px solid #444;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #e6f2ff;
    }

    .section-header {
        background-color: #d9edf7;
        font-weight: bold;
        text-align: center;
        font-size: 18px;
    }
</style>

<!-- Institution Details -->
<table>
    <tr>
        <th colspan="2" class="section-header">Institution Details</th>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Institution Logo</td>
        <td><!-- Logo placeholder --></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Institution Name</td>
        <td>ATPR TRAINING CENTER</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Province</td>
        <td>CITY OF KIGALI</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>District</td>
        <td>NYARUGENGE</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Sector</td>
        <td>MUHIMA</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Cell</td>
        <td>UBUMWE</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Village</td>
        <td>ISANGANO</td>
    </tr>
</table>

<!-- Contact Person -->
<table>
    <tr>
        <th colspan="2" class="section-header">Contact Person</th>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Name</td>
        <td>ACP Rtd <A>AHIMANA Anselme</A></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Phone Number</td>
        <td>0788456099</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Email</td>
        <td>aahimana@yahoo.fr</td>
    </tr>
</table>

<!-- Student Information -->
<table>
    <tr>
        <th colspan="15" class="section-header text-center">Student's Information for Short Courses</th>
    </tr>
    <tr>
        <th>Student No</th>
        <th>ID No</th>
        <th>Student Names</th>
        <th>DOB</th>
        <th>Gender</th>
        <th>District</th>
        <th>Disability</th>
        <th>Marital Status</th>
        <th>Trainee's <br>Phone Number</th>
        <th>Phone No <br>(Student/Guardian)</th>
        <th>Education Level</th>
        <th>School/Institution</th>
        <th>Training/Trade</th>
        <th>Training Type</th>
        <th>Training Start date</th>
        <th>Training End date</th>
        <th>Graduate Status</th>
    </tr>
    <tr>
        @foreach($students as $index => $student)
        <td>{{ $student->student_id }}</td>
        <td>{{ $student->id_number }}</td>
        <td>{{ $student->full_name }}</td>
        <td>{{ $student->dob }}</td>
        <td>{{ $student->gender }}</td>
        <td>Kicukiro</td>
        <td>{{ $student->disability}}</td>
        <td>{{ $student->marital_status}}</td>
        <td>{{ $student->phone }}</td>
        <td>{{ $student->phone_next_of_kin }}</td>
        <td>{{ $student->education_level }}</td>
        <td>ATPR T.C</td>
        <td>INOZAMWUGA MU GUTWARA <br>ABANTU MU BURYO BWA RUSANGE</td>
        <td>Dual Training</td>
        <td>10/22/2024</td>
        <td>01/26/2025</td>
        <td>Ongoing</td>
        @endforeach
    </tr>
</table>

<!-- Signature Table (starts in column B) -->
<table>
    <tr>
        <td>&nbsp;</td>
        <td><strong>Prepared by:<br></strong> ACP AHIMANA Anselme<br>Se<br>School Manager of ATPR T.C</td>
        <td><strong>Approved by:<br></strong> MWUNGUZI Theoneste<br>Se<br>Chairperson ATPR</td>
    </tr>
</table>