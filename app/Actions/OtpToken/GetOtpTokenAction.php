<?php

namespace App\Actions\OtpToken;

use App\Models\OtpToken;

class GetOtpTokenAction
{
    public function __construct(
        private OtpToken $otpToken
    ) {}

    public function execute(array $getOtpTokenRecordOptions)
    {
        $email = $getOtpTokenRecordOptions['email'];
        $purpose = $getOtpTokenRecordOptions['purpose'];

        return $this->otpToken->where([
            'email' => $email,
            'purpose' => $purpose,
        ])->first();
    }
}
