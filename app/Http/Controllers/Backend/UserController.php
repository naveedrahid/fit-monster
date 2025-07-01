<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\ClientProfile;
use App\Models\Package;
use App\Models\Shift;
use App\Models\TrainerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('backend.role-permission.user.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $shifts = Shift::all();
        $packages = Package::all();
        $addons = Addon::all();
        $packageAddons = Package::with('addons')->get()->mapWithKeys(function ($package) {
            return [$package->id => $package->addons->pluck('id')->toArray()];
        });

        return view('backend.role-permission.user.create', compact('roles', 'shifts', 'packages', 'addons', 'packageAddons'));
    }

    public function store(Request $request)
    {
        $rules = [
            'shift_id' => 'required|exists:shifts,id',
            'name' => 'required|string|max:255',
            'age' => 'required|numeric|min:18|max:60',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
            'user_type' => ['required', Rule::in(['client', 'trainer'])],
            'phone' => 'required|string|max:15',
            'emergency_contact' => 'nullable|string|max:15',
        ];

        if ($request->user_type === 'trainer') {
            $rules = array_merge($rules, [
                'specialization' => 'required|string|max:255',
                'experience' => 'required|integer|min:0',
                'salary' => 'required|numeric|min:0',
            ]);
        }

        if ($request->user_type === 'client') {
            $rules['plan_type'] = ['required', Rule::in(['default', 'custom', 'addon_only'])];

            if (in_array($request->plan_type, ['default', 'custom'])) {
                $rules['package_id'] = 'required|exists:packages,id';
            } else {
                $rules['package_id'] = 'nullable';
            }

            $rules = array_merge($rules, [
                'height' => 'required|numeric|min:0',
                'weight' => 'required|numeric|min:0',
                'goal' => 'required|string|max:255',
                'addons' => 'nullable|array',
                'addons.*' => 'exists:addons,id',
            ]);
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'age' => $validated['age'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'shift_id' => $validated['shift_id'],
                'phone' => $validated['phone'],
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'user_type' => $validated['user_type'],
            ]);

            $user->syncRoles($validated['roles']);

            if ($validated['user_type'] === 'client') {
                $clientProfile = $user->clientProfile()->create([
                    'package_id' => $validated['package_id'] ?? null,
                    'height' => $validated['height'],
                    'weight' => $validated['weight'],
                    'goal' => $validated['goal'],
                ]);

                $addonIds = [];

                if ($validated['plan_type'] === 'default') {
                    $package = Package::with('addons')->find($validated['package_id']);
                    $addonIds = $package ? $package->addons->pluck('id')->toArray() : [];
                } elseif (!empty($validated['addons'])) {
                    $addonIds = $validated['addons'];
                }

                if (!empty($addonIds)) {
                    $addonData = collect($addonIds)->map(function ($addonId) use ($clientProfile, $validated) {
                        return [
                            'client_profile_id' => $clientProfile->id,
                            'package_id' => $validated['package_id'] ?? null,
                            'addon_id' => $addonId,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray();

                    DB::table('client_profile_addons')->insert($addonData);
                }
            }

            if ($validated['user_type'] === 'trainer') {
                $user->trainerProfile()->create([
                    'specialization' => $validated['specialization'],
                    'experience' => $validated['experience'],
                    'salary' => $validated['salary'],
                ]);
            }

            DB::commit();

            return redirect()->route('users.index')->with('status', 'User created successfully with profile');
        } catch (\Exception $e) {
            DB::rollBack();
            dd([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $shifts = Shift::all();
        $packages = Package::all();
        $addons = Addon::all();
        $packageAddons = Package::with('addons')->get()->mapWithKeys(function ($package) {
            return [$package->id => $package->addons->pluck('id')->toArray()];
        });

        $client = $user->clientProfile;
        $trainer = $user->trainerProfile;

        $selectedAddonIds = $client?->addons->pluck('id')->toArray() ?? [];
        $packageAddonIds = $client && $client->package ? $client->package->addons->pluck('id')->toArray() : [];

        $planType = 'addon_only';
        if ($client && $client->package_id && empty(array_diff($selectedAddonIds, $packageAddonIds))) {
            $planType = 'default';
        } elseif ($client && $client->package_id && !empty(array_diff($selectedAddonIds, $packageAddonIds))) {
            $planType = 'custom';
        }

        return view('backend.role-permission.user.edit', compact(
            'user',
            'roles',
            'userRoles',
            'shifts',
            'packages',
            'addons',
            'packageAddons',
            'planType',
            'selectedAddonIds',
            'client',
            'trainer'
        ));
    }

    public function update(Request $request, User $user)
    {
        // dd($user->clientProfile);
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
            'shift_id' => 'required|exists:shifts,id',
            'phone' => 'required|string|max:15',
            'emergency_contact' => 'nullable|string|max:15',
            'user_type' => 'required|string|in:client,trainer',
        ];

        if ($request->user_type === 'client') {
            $rules['plan_type'] = ['required', Rule::in(['default', 'custom', 'addon_only'])];

            if (in_array($request->plan_type, ['default', 'custom'])) {
                $rules['package_id'] = 'required|exists:packages,id';
            } else {
                $rules['package_id'] = 'nullable';
            }

            $rules = array_merge($rules, [
                'height' => 'required|numeric|min:0',
                'weight' => 'required|numeric|min:0',
                'goal' => 'required|string|max:255',
                'addons' => 'nullable|array',
                'addons.*' => 'exists:addons,id',
            ]);
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'shift_id' => $validated['shift_id'],
                'phone' => $validated['phone'],
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $user->password,
                'user_type' => $validated['user_type'],
            ]);

            $user->syncRoles($validated['roles']);

            if ($request->user_type === 'client') {
                $clientProfile = $user->clientProfile;
                $clientProfile->update([
                    'package_id' => $validated['package_id'] ?? null,
                    'height' => $validated['height'],
                    'weight' => $validated['weight'],
                    'goal' => $validated['goal'],
                ]);

                // Delete old addons
                DB::table('client_profile_addons')->where('client_profile_id', $clientProfile->id)->delete();

                // Insert updated addons
                $addonIds = [];
                if ($validated['plan_type'] === 'default') {
                    $package = Package::with('addons')->find($validated['package_id']);
                    $addonIds = $package ? $package->addons->pluck('id')->toArray() : [];
                } elseif (!empty($validated['addons'])) {
                    $addonIds = $validated['addons'];
                }

                if (!empty($addonIds)) {
                    $addonData = collect($addonIds)->map(function ($addonId) use ($clientProfile, $validated) {
                        return [
                            'client_profile_id' => $clientProfile->id,
                            'package_id' => $validated['package_id'] ?? null,
                            'addon_id' => $addonId,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray();

                    DB::table('client_profile_addons')->insert($addonData);
                }
            }

            DB::commit();
            return redirect()->route('users.index')->with('status', 'User updated successfully');
        } catch (\Exception $e) {
            dd([
                'Message' => $e->getMessage(),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User Delete Successfully');
    }
}
