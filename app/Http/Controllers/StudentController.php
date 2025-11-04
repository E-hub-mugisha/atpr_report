<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'intake_no' => 'required',
            'intake_year' => 'required',
        ]);

        // Get latest student number for that intake/year
        $lastStudent = Student::where('intake_no', $request->intake_no)
            ->where('intake_year', $request->intake_year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastStudent ? ((int)substr($lastStudent->student_id, -6) + 1) : 1;
        $formattedNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        // Generate student ID like ATC/IGAK/01/24/000001
        $student_id = "ATC/IGAK/{$request->intake_no}/{$request->intake_year}/{$formattedNumber}";

        Student::create(array_merge($request->all(), [
            'student_id' => $student_id,
        ]));

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }


    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Student deleted successfully!');
    }
}
