<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\PasswordManagement\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPasswordResetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:school_staff,email'],
            'token' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'The provided email address does not exist in our records.',
            'token.required' => 'The token is required',
            'new_password.required' => 'The password is required.',
            'new_password.string' => 'The password must be a valid string.',
            'new_password.min' => 'The password must be at least 8 characters long.',
            'new_password.max' => 'The password may not be longer than 20 characters.',
        ];
    }
}
