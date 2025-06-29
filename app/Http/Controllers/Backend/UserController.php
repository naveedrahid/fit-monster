<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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

        return view('backend.role-permission.user.create', compact('roles', 'shifts', 'packages'));
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
            'type' => ['required', Rule::in(['client', 'trainer'])],
        ];

        if ($request->type === 'trainer') {
            $rules = array_merge($rules, [
                'specialization' => 'required|string|max:255',
                'experience' => 'required|integer|min:0',
                'salary' => 'required|numeric|min:0',
            ]);
        }

        if ($request->type === 'client') {
            $rules = array_merge($rules, [
                'package_id' => 'required|exists:packages,id',
                'height' => 'required|numeric|min:0',
                'weight' => 'required|numeric|min:0',
                'goal' => 'required|string|max:255',
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
            ]);

            $user->syncRoles($request->roles);
            // dd($user);

            if ($validated['type'] === 'client') {
                $user->clientProfile()->create([
                    'package_id' => $validated['package_id'],
                    'height' => $validated['height'],
                    'weight' => $validated['weight'],
                    'goal' => $validated['goal'],
                ]);
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
            return back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    // public function store(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $rules = [
    //             'shift_id' => 'required|exists:shifts,id',
    //             'name' => 'required|string|max:255',
    //             'age' => 'required|numeric|min:18|max:60',
    //             'gender' => 'required|string|in:male,female',
    //             'email' => 'required|email|max:255|unique:users,email',
    //             'password' => 'required|string|min:8|max:20',
    //             'roles' => 'required',
    //             'type' => ['required', Rule::in(['client', 'trainer'])],
    //         ];

    //         if ($request->type === 'trainer') {
    //             $rules = array_merge($rules, [
    //                 'specialization' => 'required|string|max:255',
    //                 'experience' => 'required|integer|min:0',
    //                 'salary' => 'required|numeric|min:0',
    //             ]);
    //         }

    //         if ($request->type === 'client') {
    //             $rules = array_merge($rules, [
    //                 'package_id' => 'required|exists:packages,id',
    //                 'height' => 'required|numeric|min:0',
    //                 'weight' => 'required|numeric|min:0',
    //                 'goal' => 'required|string|max:255',
    //             ]);
    //         }

    //         $validated = $request->validate($rules);

    //         Log::info('Validation Passed', $validated);

    //         $user = User::create([
    //             'name' => $validated['name'],
    //             'age' => $validated['age'],
    //             'gender' => $validated['gender'],
    //             'email' => $validated['email'],
    //             'password' => Hash::make($validated['password']),
    //             'shift_id' => $validated['shift_id'],
    //         ]);

    //         Log::info('User Created', ['user' => $user]);

    //         $user->syncRoles($validated['roles']);

    //         // Profile creation yahan hoga baad mein
    //         DB::commit();

    //         return redirect()->route('users.index')->with('status', 'User created successfully with roles');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('User creation failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //         return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
    //     }
    // }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $shifts = Shift::all();
        return view('backend.role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'shifts' => $shifts
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'shift_id' => $request->shift_id,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('status', 'User Updated Successfully with roles');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User Delete Successfully');
    }
}
