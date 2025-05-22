<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('backend.packages.index', compact('packages'));
    }

    public function create()
    {
        $package = new Package();
        return view('backend.packages._form', compact('package'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer|min:1',
        ]);
        $package = new Package();
        $package->name = $request->name;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->duration_days = $request->duration_days;
        $package->save();
        return redirect()->route('backend.packages.index')->with('success', 'Package created successfully');
    }

    public function edit(Package $package)
    {
        return view('backend.packages._form', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer|min:1',
        ]);
        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
        ]);
        return redirect()->route('backend.packages.index')->with('success', 'Package updated successfully');
    }
}
