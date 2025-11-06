<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Course $course)
    {
        $modules = $course->modules()->orderBy('order')->get();
        return view('modules.index', compact('course', 'modules'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $request->merge(['module_code' => 'M' . str_pad(Module::max('id') + 1, 5, '0', STR_PAD_LEFT)]);
        $course->modules()->create($request->all());
        return back()->with('success', 'Module added.');
    }

    public function update(Request $request, Course $course, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'module_code' => 'required|string|unique:modules,module_code,' . $module->id,
        ]);

        $module->update($request->all());
        return back()->with('success', 'Module updated.');
    }

    public function destroy(Course $course, Module $module)
    {
        $module->delete();
        return back()->with('success', 'Module deleted.');
    }
}
