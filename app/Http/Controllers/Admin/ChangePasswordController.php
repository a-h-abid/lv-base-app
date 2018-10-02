<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('admin/auth/change-password');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'current_password' => [
                'required',
                'string',
                function($attribute, $value, $fail) use ($request) {
                    if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
                        return $fail('The current password does not match.');
                    }
                },
            ],
            'new_password' => ['required','string','confirmed'],
        ]);

        // Change Password
        $user = Auth::guard('admin')->user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();

        $request->session()->flash('flash.success', 'Password Changed Successfully.');

        return redirect()->back();
    }
}
