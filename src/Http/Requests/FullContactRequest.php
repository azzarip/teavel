<?php

namespace Azzarip\Teavel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FullContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|phone',
            'privacy_policy' => 'required|accepted',
        ];
    }
}
