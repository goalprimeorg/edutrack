<?php

namespace App\Actions\OtpToken;

use App\Models\OtpToken;

class DeleteOtpTokenAction
{
    public function __construct(
        private OtpToken $otpToken
    ) {}

    public function execute(array $deleteOtpTokenRecordOptions)
    {
        $purpose = $deleteOtpTokenRecordOptions['purpose'];
        $email = $deleteOtpTokenRecordOptions['email'];

        $this->otpToken->where([
            'email' => $email,
            'purpose' => $purpose,
        ])->delete();
    }
}
