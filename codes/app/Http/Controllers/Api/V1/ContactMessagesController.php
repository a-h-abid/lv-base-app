<?php

namespace App\Http\Controllers\Api\V1;

use App\Eloquents\ContactMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\ContactFormRequest;
use App\Http\Resources\ContactMessageResource;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contactMessages = app()->make(ContactMessage::class);

        $contactMessages = $contactMessages->paginate();

        return ContactMessageResource::collection($contactMessages);
    }

    /**
     * Create a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request)
    {
        $data = $request->validated();

        $contactMessage = ContactMessage::create($data);

        return (new ContactMessageResource($contactMessage))
            ->additional([
                'message' => 'Created',
            ]);
    }

    /**
     * Display the provided resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $contactMessage = ContactMessage::findOrFail($id);

        return (new ContactMessageResource($contactMessage));
    }

}
