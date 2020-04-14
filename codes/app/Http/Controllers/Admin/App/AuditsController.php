<?php

namespace App\Http\Controllers\Admin\App;

use Altek\Accountant\Models\Ledger;
use App\Http\Controllers\Controller;

class AuditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audits = app()->make(Ledger::class);

        $total = $audits->count();

        $audits = $audits->with('user')->latest()->paginate();

        return view('admin/auth/app/audits/index', compact('audits','total'));
    }

    /**
     * Show the page for viewing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $audit = Ledger::findOrFail($id);

        return view('admin/auth/app/audits/show', [
            'audit' => $audit,
        ]);
    }
}
