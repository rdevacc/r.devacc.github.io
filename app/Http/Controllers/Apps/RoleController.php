<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get Roles
        $roles = Role::when(request()->q, function ($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->with('permissions')->latest()->paginate(10);

        // Render with Inertia
        return inertia('Apps/Roles/Index', [
            'roles' => $roles,
        ]);
    }


    /**
     * show create form for creating new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get All Permissions
        $permissions = Permission::all();

        // Render with Inertia
        return inertia('Apps/Roles/Create', [
            'permissions' => $permissions,
        ]);
    }


    /**
     * store a newly created resource in storage 
     *
     * @param  mixed $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Validate Request
         */
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        // Create Role
        $role = Role::create(['name' => $request->name]);

        // Assign Permissions to Role
        $role->givePermissionTo($request->permissions);

        // Redirect
        return redirect()->route('apps.roles.index');
    }


    /**
     * show edit form for editing the spesified resource
     *
     * @param  mixed $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // Get Role
        $role = Role::with('permissions')->findOrFail($id);

        // Get Permission All
        $permissions = Permission::all();

        return inertia('Apps/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }


    /**
     * update a specified resource in storage
     *
     * @param  mixed $request
     * @param  mixed $role int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        /**
         * Validate Request
         */
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        // Update Role
        $role->update(['name' => $request->name]);

        // Sync Permission
        $role->syncPermissions($request->permissions);

        // Redirect
        return redirect()->route('apps.roles.index');
    }


    /**
     * destroy or remove the specified resource from storage
     *
     * @param  mixed $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Get Role by ID
        $role = Role::findOrFail($id);

        // Delete Role
        $role->delete();

        // Redirect
        return redirect()->route('apps.roles.index');
    }
}
