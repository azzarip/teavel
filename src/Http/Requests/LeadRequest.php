<?php

namespace Azzarip\Teavel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'privacy_policy' => 'required|accepted',
        ];
    }
}
