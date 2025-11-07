<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Sample data - replace with actual data retrieval logic
        $totalStudents = Student::count();
        $totalStudentsMonth =  Student::whereMonth('created_at', now()->month)->count();
        $totalStudentsWeek =  Student::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $activeStudents =  Student::where('status', 'active')->count();
        $avgStudents =  Student::avg('id'); 
        $courseName = Course::first()->name ?? 'N/A';
        $students = Student::all();
        $users = User::all();

        return view('dashboard', compact(
            'totalStudents',
            'totalStudentsMonth',
            'totalStudentsWeek',
            'activeStudents',
            'avgStudents',
            'courseName',
            'students',
            'users'
        ));
    }
}
