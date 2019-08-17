<?php

namespace App\Http\Controllers\Api\V1;

use App\Eloquents\Faq;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faqs = app()->make(Faq::class);

        $faqs = $faqs->paginate();

        return FaqResource::collection($faqs);
    }

    /**
     * Display the provided resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        return (new FaqResource($faq));
    }

}
