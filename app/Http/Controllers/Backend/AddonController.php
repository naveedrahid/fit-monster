<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Addon;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::paginate(15);
        return view('backend.addons.index', compact('addons'));
    }

    public function create()
    {
        $addon = new Addon();
        return view('backend.addons._form', compact('addon'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:addons,name',
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        Addon::create($validatedData);

        return redirect()->route('addons.index')->with('success', 'Addon created successfully.');
    }

    public function edit(Addon $addon)
    {
        return view('backend.addons._form', compact('addon'));
    }

    public function update(Addon $addon, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:addons,name,' . $addon->id,
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $addon->update($validatedData);

        return redirect()->route('addons.index')->with('success', 'Addon update successfully.');
    }


    public function destroy(Addon $addon)
    {
        $addon->delete();

        return redirect()->back()->with('success', 'Addon deleted successfully.');
    }
}
