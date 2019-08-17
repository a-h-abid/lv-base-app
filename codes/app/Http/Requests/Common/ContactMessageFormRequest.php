<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['nullable'],
            'message' => ['required'],
        ];

        if ($this->user()->check()) {
            $this->merge([
                'name' => $this->user()->name,
                'email' => $this->user()->email,
                'phone' => $this->user()->phone,
            ]);
        }

        return $rules;
    }
}
