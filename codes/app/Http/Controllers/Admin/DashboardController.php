<?php

namespace App\Http\Controllers\Admin;

use App\Eloquents\Admin;
use App\Eloquents\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $adminsCount = Admin::count();
        $usersCount = User::count();

        return view('admin/auth/dashboard', compact('adminsCount', 'usersCount'));
    }
}
