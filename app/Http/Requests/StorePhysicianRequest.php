<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhysicianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return 
        [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'email', 'unique:physicians'],
            'specialization' => ['required', 'max:30', 'string'],
            'contact' => ['required', 'regex:/^\+?20(\d{10}|\d{9})$/']  
        ];
    }
}
