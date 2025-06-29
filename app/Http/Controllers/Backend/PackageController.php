<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Addon;
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
        $addons = Addon::all();
        return view('backend.packages._form', compact('package', 'addons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer|min:1',
            'addons' => 'required|array',
            'addons.*' => 'exists:addons,id',
        ]);

        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
        ]);

        if ($request->has('addons')) {
            $package->addons()->attach($request->addons);
        }
        return redirect()->route('packages.index')->with('success', 'Package created successfully');
    }

    public function edit(Package $package)
    {
        $addons = Addon::all();
        $selectedAddons = $package->addons()->pluck('addons.id')->toArray();
        return view('backend.packages._form', compact('package', 'addons', 'selectedAddons'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer|min:1',
            'addons' => 'required|array',
            'addons.*' => 'exists:addons,id',
        ]);
        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
        ]);
        
        $package->addons()->sync($request->addons ?? []);

        return redirect()->route('packages.index')->with('success', 'Package updated successfully');
    }

    public function destroy(Package $package) {
        $package->addons()->detach();
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully');
    }
}
