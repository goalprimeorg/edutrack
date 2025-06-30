<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNewSchoolStaffEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private array $sendNewSchoolStaffEmailOptions) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New School Staff Account',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $email = $this->sendNewSchoolStaffEmailOptions['email'];
        $password = $this->sendNewSchoolStaffEmailOptions['password'];
        $school = $this->sendNewSchoolStaffEmailOptions['school'];
        $role = $this->sendNewSchoolStaffEmailOptions['role'];
        $fullName = $this->sendNewSchoolStaffEmailOptions['full_name'];

        return new Content(
            view: 'emails.onboarding.send-school-staff-invite-mail-template',
            with: [
                'email' => $email,
                'fullName' => $fullName,
                'role' => $role,
                'school' => $school,
                'password' => $password,
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
