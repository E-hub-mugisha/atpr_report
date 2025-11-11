<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use Illuminate\Http\Request;

class IntakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $intakes = Intake::all();
        return view('intakes.index', compact('intakes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|digits:4|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:open,closed',
        ]);

        Intake::create($request->all());
        return redirect()->route('intakes.index')
            ->with('success', 'Intake created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Intake $intake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intake $intake)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intake $intake)
    {
        //
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|digits:4|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:open,closed',
        ]);

        $intake->update($request->all());
        return redirect()->route('intakes.index')
            ->with('success', 'Intake updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intake $intake)
    {
        //
        $intake->delete();
        return redirect()->route('intakes.index')
            ->with('success', 'Intake deleted successfully.');
    }
}
