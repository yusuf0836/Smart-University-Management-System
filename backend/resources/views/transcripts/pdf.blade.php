<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Transcript</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:13px;
        }

        h2,h3{
            text-align:center;
            margin:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table,th,td{
            border:1px solid #000;
        }

        th,td{
            padding:8px;
            text-align:center;
        }

        .info{
            margin-top:20px;
        }

        .footer{
            margin-top:30px;
        }

        .signature{
            text-align:right;
            margin-top:60px;
        }
    </style>

</head>

<body>

<h2>Smart University Management System</h2>
<h3>Official Academic Transcript</h3>

<div class="info">

<p><strong>Student Name:</strong> {{ $student->name }}</p>

<p><strong>Student ID:</strong> {{ $student->student_id }}</p>

<p><strong>Semester:</strong> {{ $semester->name }}</p>

</div>

<table>

<thead>

<tr>

<th>Course Code</th>

<th>Course</th>

<th>Credit</th>

<th>Marks</th>

<th>Grade</th>

<th>Grade Point</th>

</tr>

</thead>

<tbody>

@foreach($results as $result)

<tr>

<td>{{ $result->enrollment?->course?->course_code ?? 'N/A' }}</td>

<td>{{ $result->enrollment?->course?->course_title ?? 'N/A' }}</td>

<td>{{ $result->enrollment?->course?->credit ?? 'N/A' }}</td>

<td>{{ $result->marks }}</td>

<td>{{ $result->grade }}</td>

<td>{{ $result->grade_point }}</td>

</tr>

@endforeach

</tbody>

</table>

<div class="footer">

<p><strong>Total Credits:</strong> {{ $transcript->total_credits }}</p>

<p><strong>Semester GPA:</strong> {{ $transcript->semester_gpa }}</p>

<p><strong>CGPA:</strong> {{ $transcript->cgpa }}</p>

<p><strong>Status:</strong> {{ $transcript->status }}</p>

</div>

<div class="signature">

_____________________<br>

Controller of Examination

</div>

</body>
</html>