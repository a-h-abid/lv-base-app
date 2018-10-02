<?php

namespace App\Http\Requests\Admin\Users;

use App\Rules\LatitudeRule;
use App\Rules\LongitudeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
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
            'name' => ['required', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($this->route('id')),
            ],
            'active' => ['boolean'],
            'roles' => ['required'],
            'phone' => ['nullable', 'string'],
        ];

        if ($this->isMethod('put')) {
            $rules['password'] = ['confirmed'];
        } else {
            $rules['password'] = ['required','confirmed'];
        }

        return $rules;
    }
}
