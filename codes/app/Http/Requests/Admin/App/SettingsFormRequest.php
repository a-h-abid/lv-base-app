<?php

namespace App\Http\Requests\Admin\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingsFormRequest extends FormRequest
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
            'settings.help-url' => ['required', 'url'],
        ];

        return $rules;
    }

    /**
     * Custom Validation Messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'settings.help-url.url' => 'The URL Format is invalid.',
        ];
    }
}
