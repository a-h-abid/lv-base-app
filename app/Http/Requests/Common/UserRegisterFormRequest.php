<?php

namespace App\Http\Requests\Api;

use App\Rules\LatitudeRule;
use App\Rules\LongitudeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterFormRequest extends FormRequest
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
                Rule::unique('users'),
            ],
            'password' => ['required','confirmed'],
            'active' => ['boolean'],
            'role' => [
                'required',
                Rule::exists('roles', 'name')->where(function ($query) {
                    $query->whereIn('guard_name', ['web', 'api']);
                }),
            ],
            'phone' => ['nullable', 'string'],
        ];

        return $rules;
    }
}
