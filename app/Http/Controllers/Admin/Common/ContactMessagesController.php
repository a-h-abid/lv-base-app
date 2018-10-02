<?php

namespace App\Http\Controllers\Admin\Common;

use App\Eloquents\ContactMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactMessages = app()->make(ContactMessage::class);

        $total = $contactMessages->count();

        $contactMessages = $contactMessages->orderBy('id', 'desc')->paginate();

        return view('admin/auth/common/contact-messages/index', compact('contactMessages','total'));
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactMessage = ContactMessage::findOrFail($id);

        return view('admin/auth/common/contact-messages/show', [
            'contactMessage' => $contactMessage,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contactMessage = ContactMessage::findOrFail($id);

        $contactMessage->delete();

        session()->flash('flash.success', 'Contact ID "'.$contactMessage->id.'" deleted!');

        return redirect()->back();
    }
}
