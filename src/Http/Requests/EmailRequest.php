<?php

namespace Azzarip\Teavel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'privacy_policy' => 'required|accepted',
        ];
    }
}
