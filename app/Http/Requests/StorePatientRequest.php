<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'medical_history' => 'required|string|max:2048', 
            'address' => 'required|string|max:255',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'photos.*.image' => 'Each photo must be an image file.',
            'photos.*.mimes' => 'Each photo must be a jpeg, png, jpg, gif, or svg file.',
            'photos.*.max' => 'Each photo may not be greater than 2048 kilobytes.',
        ];
    }
}
