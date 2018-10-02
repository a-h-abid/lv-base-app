<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\RolePermissionsFormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        $permissions = config('permissions.guard:'.$role->guard_name);

        return view('admin/auth/users/roles/permissions/form', [
            'form_mode' => 'edit',
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Users\RolePermissionsFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolePermissionsFormRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        $data = $request->validated();

        $newPermissions = [];
        foreach ($data['permission'] as $permissionName) {
            $newPermissions[] = Permission::firstOrCreate(['name' => $permissionName]);
        }

        $role->syncPermissions($newPermissions);

        session()->flash('flash.success', 'Role permissions updated!');

        return redirect()->back();
    }
}
