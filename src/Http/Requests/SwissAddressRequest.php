<?php

namespace Azzarip\Teavel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SwissAddressRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'co' => 'nullable|string|max:255',
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|digits:4',
            'info' => 'nullable|string|max:500'
        ];
    }
    
    protected function passedValidation(): void
    {
        $new = [
            'name' => ucwords($this->name),
            'line1' => ucfirst($this->line1),
            'city' => ucfirst($this->city),
        ];

        $this->replace(
            array_replace($this->all(), $new)
        );
    }
}
