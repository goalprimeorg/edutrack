<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\PasswordManagement\ChangePassword;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string', 'min:8', 'max:20'],
            'new_password' => ['required', 'string', 'min:8', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'The old password is required.',
            'old_password.string' => 'The old password must be a valid string.',
            'old_password.min' => 'The old password must be at least 8 characters long.',
            'old_password.max' => 'The old password may not be longer than 20 characters.',
            'new_password.required' => 'The new password is required.',
            'new_password.string' => 'The new password must be a valid string.',
            'new_password.min' => 'The new password must be at least 8 characters long.',
            'new_password.max' => 'The new password may not be longer than 20 characters.',
        ];
    }
}
