<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        // Change this to true, otherwise it will return 403 Forbidden
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // FIX: 'unique:table,column' -> 'unique:users,email'
            'password' => 'nullable|min:8'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'password' => 'Kata Sandi'
        ];
    }
}
