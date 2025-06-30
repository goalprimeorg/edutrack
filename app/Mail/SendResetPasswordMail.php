<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private array $sendResetPasswordMailOptions)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password OTP Token',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $fullName = $this->sendResetPasswordMailOptions['full_name'];
        $token = $this->sendResetPasswordMailOptions['token'];
        $expiresAt = $this->sendResetPasswordMailOptions['expires_at'];

        return new Content(
            view: 'emails.password-management.send-password-reset-otp-mail-template',
            with: [
                'token' => $token,
                'expiresAt' => $expiresAt,
                'fullName' => $fullName,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
