<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Mark;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Show all lessons under one module.
     */
    public function index(Module $module)
    {
        $module->load('lessons'); // load lessons with module
        return view('lessons.index', compact('module'));
    }

    /**
     * Show a specific lesson.
     */
    public function show($moduleId, $lessonId)
    {
        // Find the lesson within the module
        $lesson = Lesson::where('id', $lessonId)
            ->where('module_id', $moduleId)
            ->firstOrFail();

        $lessonmarks = Mark::where('lesson_id', $lesson->id)->with('student')->get();
        $students = Student::all();

        return view('lessons.marks', compact('lesson', 'lessonmarks', 'students'));
    }


    /**
     * Store a new lesson for a specific module.
     */
    public function store(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'lesson_code' => 'required|string|unique:lessons,lesson_code',
        ]);

        $module->lessons()->create([
            'title' => $request->title,
            'content' => $request->content,
            'lesson_code' => $request->lesson_code,
        ]);

        return back()->with('success', 'Lesson added.');
    }

    /**
     * Update a lesson.
     */
    public function update(Request $request, Module $module, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'lesson_code' => 'required|string|unique:lessons,lesson_code,' . $lesson->id,
        ]);

        $lesson->update($request->only(['title', 'content', 'lesson_code']));

        return back()->with('success', 'Lesson updated.');
    }

    /**
     * Delete a lesson.
     */
    public function destroy(Module $module, Lesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted.');
    }
}
