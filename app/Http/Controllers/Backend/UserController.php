<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
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
        $users = User::with([
            'payments',
        ])->paginate(20);
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

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'age' => $validated['age'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'shift_id' => $validated['shift_id'],
                'phone' => $validated['phone'],
                'emergency_contact' => $validated['emergency_contact'] ?? null,
            ]);

            $user->syncRoles($validated['roles']);

            if ($validated['type'] === 'client') {
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


            if ($validated['type'] === 'trainer') {
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
            // dd('Exception caught: ', $e->getMessage(), $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        $user->load([
            'roles',
            'shift',
            'clientProfile.package.addons',
            'clientProfile.addons',
            'trainerProfile',
        ]);

        $roles      = Role::pluck('name', 'name')->all();
        $userRoles  = $user->roles->pluck('name', 'name')->all();
        $shifts     = Shift::select('id', 'name', 'start_time', 'end_time')->get();
        $addons     = Addon::select('id', 'name', 'price')->get();

        $packages = Package::select('id', 'name')
            ->with('addons:id')
            ->get();

        $packageAddons = $packages->mapWithKeys(
            fn($p) => [$p->id => $p->addons->pluck('id')->all()]
        );

        $selectedAddonIds = $user->clientProfile?->addons?->pluck('id')->all() ?? [];
        $packageAddonIds  = $user->clientProfile?->package?->addons?->pluck('id')->all() ?? [];
        $hasPackage       = !empty($user->clientProfile?->package_id);

        $planType = 'addon_only';
        if ($hasPackage) {
            $same = empty(array_diff($selectedAddonIds, $packageAddonIds))
                && empty(array_diff($packageAddonIds, $selectedAddonIds));
            $planType = $same ? 'default' : 'custom';
        }

        $isClient  = $user->hasRole('client');
        $isTrainer = $user->hasRole('trainer');
        if (!$isClient && !$isTrainer) $isClient = true;

        $activeTab = $isClient ? 'client' : 'trainer';

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
            'isClient',
            'isTrainer',
            'activeTab'
        ));
    }

    public function show(User $user)
    {
        $user->load([
            'shift',
            'clientProfile.package',
            'clientProfile.addons',
            'clientProfile.payments',
        ]);
        return view('backend.role-permission.user.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $hasClientSection = $request->filled('plan_type') || $user->clientProfile()->exists();

        $rules = [
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'           => 'nullable|string|min:8|max:20',
            'roles'              => 'required|array|min:1',
            'roles.*'            => 'string|exists:roles,name',
            'shift_id'           => 'required|exists:shifts,id',
            'phone'              => 'required|string|max:15',
            'emergency_contact'  => 'nullable|string|max:15',
        ];

        if ($hasClientSection) {
            $rules['plan_type'] = ['required', Rule::in(['default', 'custom', 'addon_only'])];

            if (in_array($request->input('plan_type'), ['default', 'custom'], true)) {
                $rules['package_id'] = 'required|exists:packages,id';
            } else {
                $rules['package_id'] = 'nullable';
            }

            $rules = array_merge($rules, [
                'height'            => 'required|numeric|min:0',
                'weight'            => 'required|numeric|min:0',
                'goal'              => 'required|string|max:255',
                'addon_ids'         => 'nullable|array',
                'addon_ids.*'       => 'integer|exists:addons,id',
            ]);
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            $user->fill([
                'name'              => $validated['name'],
                'email'             => $validated['email'],
                'shift_id'          => $validated['shift_id'],
                'phone'             => $validated['phone'],
                'emergency_contact' => $validated['emergency_contact'] ?? null,
            ]);

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            $user->syncRoles($validated['roles']);

            if ($hasClientSection) {
                $clientProfile = $user->clientProfile()->first();
                if (!$clientProfile) {
                    $clientProfile = $user->clientProfile()->create([
                        'package_id' => null,
                        'height'     => 0,
                        'weight'     => 0,
                        'goal'       => '',
                    ]);
                }

                $clientProfile->update([
                    'package_id' => $validated['package_id'] ?? null,
                    'height'     => $validated['height'],
                    'weight'     => $validated['weight'],
                    'goal'       => $validated['goal'],
                ]);

                $addonIds = [];
                $planType = $validated['plan_type'];

                if ($planType === 'default') {
                    $package  = Package::with('addons:id')->find($validated['package_id']);
                    $addonIds = $package ? $package->addons->pluck('id')->all() : [];
                } elseif ($planType === 'custom') {
                    $addonIds = array_values($validated['addon_ids'] ?? []);
                } else {
                    $addonIds = array_values($validated['addon_ids'] ?? []);
                    $validated['package_id'] = null;
                }

                DB::table('client_profile_addons')
                    ->where('client_profile_id', $clientProfile->id)
                    ->delete();

                if (!empty($addonIds)) {
                    $now = now();
                    $rows = array_map(function ($addonId) use ($clientProfile, $validated, $now) {
                        return [
                            'client_profile_id' => $clientProfile->id,
                            'package_id'        => $validated['package_id'] ?? null,
                            'addon_id'          => (int) $addonId,
                            'is_active'         => 1,
                            'created_at'        => $now,
                            'updated_at'        => $now,
                        ];
                    }, $addonIds);

                    DB::table('client_profile_addons')->insert($rows);
                }
            }

            DB::commit();
            return redirect()->route('users.index')->with('status', 'User updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()])->withInput();
        }
    }


    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User Delete Successfully');
    }
}
