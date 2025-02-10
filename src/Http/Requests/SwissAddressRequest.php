<?php

namespace Azzarip\Teavel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SwissAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'co' => 'nullable|string|max:255',
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|digits:4',
            'info' => 'nullable|string|max:500',
        ];
    }
}
