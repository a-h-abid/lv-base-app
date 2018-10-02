<?php

namespace App\Http\Controllers\Admin\Users;

use App\Eloquents\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserFormRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = app()->make(User::class);

        $total = $users->count();

        $users = $users->paginate();

        return view('admin/auth/users/users/index', compact('users','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/auth/users/users/form', [
            'form_mode' => 'create',
            'user' => new User,
            'roles' => Role::whereIn('guard_name', ['web','api'])->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Users\UserFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $data['active'] ?? 0;

        $user = User::create($data);

        $roles = Role::find($data['roles']);
        $user->syncRoles($roles);

        session()->flash('flash.success', 'User created!');

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
        $user = User::with('roles')->findOrFail($id);

        return view('admin/auth/users/users/form', [
            'form_mode' => 'edit',
            'user' => $user,
            'roles' => Role::whereIn('guard_name', ['web','api'])->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Users\UserFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validated();
        $data['active'] = $data['active'] ?? 0;

        $user->fill($data);
        $user->save();

        $roles = Role::find($data['roles']);
        $user->syncRoles($roles);

        session()->flash('flash.success', 'User updated!');

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
        $user = User::findOrFail($id);

        $user->delete();

        session()->flash('flash.success', 'User user "'.$user->name.'" deleted!');

        return redirect()->back();
    }
}
