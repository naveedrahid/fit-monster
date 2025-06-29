<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(){
        $shifts = Shift::all();
        return view('backend.shifts.index', compact('shifts'));
    }
    public function create(){
        $shift = new Shift();
        return view('backend.shifts._form', compact('shift'));
    }

    public function edit(Shift $shift){
        return view('backend.shifts._form', compact('shift'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Shift::create($validatedData);

        return redirect()->route('shifts.index')->with('success', 'Shift created successfully');
    }

    public function update(Request $request, Shift $shift)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $shift->update($validatedData);

        return redirect()->route('shifts.index')->with('success', 'Shift updated successfully');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'Shift deleted successfully');
    }

}
