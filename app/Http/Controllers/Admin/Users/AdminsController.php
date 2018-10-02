<?php

namespace App\Http\Controllers\Admin\Users;

use App\Eloquents\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminFormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = app()->make(Admin::class);

        $total = $admins->count();

        $admins = $admins->paginate();

        return view('admin/auth/users/admins/index', compact('admins','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/auth/users/admins/form', [
            'form_mode' => 'create',
            'admin' => new Admin,
            'roles' => Role::where('guard_name', 'admin')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Users\AdminFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminFormRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $data['active'] ?? 0;

        $admin = Admin::create($data);

        $roles = Role::find($data['roles']);
        $admin->syncRoles($roles);

        session()->flash('flash.success', 'Admin created!');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::with('roles')->findOrFail($id);

        return view('admin/auth/users/admins/form', [
            'form_mode' => 'edit',
            'admin' => $admin,
            'roles' => Role::where('guard_name', 'admin')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Users\AdminFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFormRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $data = $request->validated();
        $data['active'] = $data['active'] ?? 0;

        $admin->fill($data);
        $admin->save();

        $roles = Role::find($data['roles']);
        $admin->syncRoles($roles);

        session()->flash('flash.success', 'Admin updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        $admin->delete();

        session()->flash('flash.success', 'Admin user "'.$admin->name.'" deleted!');

        return redirect()->back();
    }
}
