<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        $grouped = [];

        foreach ($permissions as $permission) {
            if (str_contains($permission->name, ' ')) {
                [$action, $module] = explode(' ', $permission->name);
                $grouped[$action][$module] = $permission;
            }
        }

        $actions = ['view', 'update', 'create', 'delete'];
        $modules = collect($permissions)
            ->map(fn($p) => explode(' ', $p->name)[1])
            ->unique()
            ->sort()
            ->values();

        return view('backend.role-permission.permission.index', compact('grouped', 'actions', 'modules'));
    }

    public function create()
    {
        return view('backend.role-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')->with('status', 'Permission Created Successfully');
    }

    public function edit(Permission $permission)
    {
        return view('backend.role-permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,' . $permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')->with('status', 'Permission Updated Successfully');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect()->route('permissions.index')->with('status', 'Permission Deleted Successfully');
    }
}
