<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Trainer;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        $trainers = Trainer::all();
        return view('courses.index', compact('courses', 'trainers'));
    }

    public function create()
    {
        return view('courses.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'trainer_id' => 'nullable|exists:trainers,id',
        ]);

        // auto generate course_code
        $request->merge(['course_code' => 'C' . str_pad(Course::max('id') + 1, 5, '0', STR_PAD_LEFT)]);

        Course::create($request->all());
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'trainer_id' => 'nullable|exists:trainers,id',
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted.');
    }

    public function assignTrainer(Request $request, Course $course)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
        ]);

        $course->trainer_id = $request->trainer_id;
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Trainer assigned successfully.');
    }
}
