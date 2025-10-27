<?php

namespace App\Http\Controllers;

use App\Imports\MarksImport;
use App\Models\Mark;
use App\Models\Module;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MarkController extends Controller
{
    public function index(Module $module)
    {
        $marks = Mark::where('module_id', $module->id)->get();
        return view('marks.index', compact('module', 'marks'));
    }

    public function store(Request $request, Module $module)
    {
        $request->validate([
            'trainee' => 'required|string|max:255',
            'i_a' => 'nullable|integer',
            'f_a' => 'nullable|integer',
            'c_a' => 'nullable|integer',
            'total' => 'nullable|integer',
            'reass' => 'nullable|integer',
            'obs' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        Mark::create([
            'trainee' => $request->trainee,
            'module_id' => $module->id,
            'i_a' => $request->i_a,
            'f_a' => $request->f_a,
            'c_a' => $request->c_a,
            'total' => $request->total,
            'reass' => $request->reass,
            'obs' => $request->obs,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Mark recorded successfully.');
    }

    public function import(Request $request, Module $module)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new MarksImport($module), $request->file('excel_file'));

        return back()->with('success', 'Marks imported successfully.');
    }
}
