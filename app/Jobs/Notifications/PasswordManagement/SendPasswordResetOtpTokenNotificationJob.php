<?php

namespace App\Jobs\Notifications\PasswordManagement;

use App\Mail\SendResetPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetOtpTokenNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private array $sendPasswordResetOtpTokenNotificationJobOptions
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fullName = $this->sendPasswordResetOtpTokenNotificationJobOptions['full_name'];
        $email = $this->sendPasswordResetOtpTokenNotificationJobOptions['email'];
        $token = $this->sendPasswordResetOtpTokenNotificationJobOptions['token'];
        $expiresAt = $this->sendPasswordResetOtpTokenNotificationJobOptions['expires_at'];

        Mail::to($email)->later(now()->addSeconds(5), new SendResetPasswordMail([
            'token' => $token,
            'expires_at' => $expiresAt,
            'full_name' => $fullName,
        ]));
    }
}
