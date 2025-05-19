<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(){
        $trainers = Trainer::all();
        return view('backend.trainers.index', compact('trainers'));
    }
    public function create(){
        $trainer = new Trainer();
        return view('backend.trainers._form', compact('trainer'));
    }

    public function edit(Trainer $trainer){
        return view('backend.trainers._form', compact('trainer'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Trainer::create($validatedData);

        return redirect()->route('backend.trainers.index')->with('success', 'Trainer created successfully');
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $trainer->update($validatedData);

        return redirect()->route('backend.trainers.index')->with('success', 'Trainer updated successfully');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('backend.trainers.index')->with('success', 'Trainer deleted successfully');
    }
}
