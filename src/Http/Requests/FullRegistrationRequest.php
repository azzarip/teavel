<?php

namespace Azzarip\Teavel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FullRegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'phone',
            'password' => 'required|min:8|max:255',
            'privacy_policy' => 'required|accepted',
            'marketing' => 'nullable',
        ];
    }
}
