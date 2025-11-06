<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::all();
        return view('trainers.index', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'qualification' => 'nullable',
            'bio'      => 'nullable'
        ]);

        Trainer::create($request->all());

        return back()->with('success', 'Trainer added successfully');
    }

    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'qualification' => 'nullable',
            'bio'      => 'nullable'
        ]);

        $trainer->update($request->all());

        return back()->with('success', 'Trainer updated successfully');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return back()->with('success', 'Trainer removed');
    }
}
