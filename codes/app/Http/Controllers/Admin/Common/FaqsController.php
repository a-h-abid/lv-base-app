<?php

namespace App\Http\Controllers\Admin\Common;

use App\Eloquents\Faq;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Common\FaqFormRequest;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = app()->make(Faq::class);

        $total = $faqs->count();

        $faqs = $faqs->paginate();

        return view('admin/auth/common/faqs/index', compact('faqs','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/auth/common/faqs/form', [
            'form_mode' => 'create',
            'faq' => new Faq,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\App\FaqFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqFormRequest $request)
    {
        $data = $request->validated();

        $faq = Faq::create($data);

        session()->flash('flash.success', 'Faq created!');

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
        $faq = Faq::findOrFail($id);

        return view('admin/auth/common/faqs/form', [
            'form_mode' => 'edit',
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\App\FaqFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqFormRequest $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $data = $request->validated();

        $faq->fill($data);
        $faq->save();

        session()->flash('flash.success', 'Faq updated!');

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
        $faq = Faq::findOrFail($id);

        $faq->delete();

        session()->flash('flash.success', 'Faq ID "'.$faq->id.'" deleted!');

        return redirect()->back();
    }
}
