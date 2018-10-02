<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminFormRequest extends FormRequest
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
                Rule::unique('admins')->ignore($this->route('id')),
            ],
            'active' => ['boolean'],
            'roles' => ['required'],
        ];

        if ($this->isMethod('put')) {
            $rules['password'] = ['confirmed'];
        } else {
            $rules['password'] = ['required','confirmed'];
        }

        return $rules;
    }
}
