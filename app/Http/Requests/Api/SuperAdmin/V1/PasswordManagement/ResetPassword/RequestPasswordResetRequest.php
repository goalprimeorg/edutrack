<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\PasswordManagement\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class RequestPasswordResetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:super_admins,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'The provided email address does not exist in our records.',
        ];
    }
}
