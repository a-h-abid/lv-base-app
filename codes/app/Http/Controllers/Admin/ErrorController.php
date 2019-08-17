<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function notFound(Request $request)
    {
        return response()->view("admin/errors.404", [], 404);
    }
}
