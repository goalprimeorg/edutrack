<?php

namespace App\Jobs\Notifications\Onboarding;

use App\Actions\SchoolStaff\GetSchoolStaffByEmailAction;
use App\Mail\SendNewSchoolStaffEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewSchoolStaffNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $sendNewSchoolStaffNotificationOptions) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->sendNewSchoolStaffNotificationOptions['email'];
        $password = $this->sendNewSchoolStaffNotificationOptions['password'];

        $getSchoolStaffByEmailAction = app(GetSchoolStaffByEmailAction::class);

        $schoolStaff = $getSchoolStaffByEmailAction->execute($email);

        Mail::to($schoolStaff)->later(now()->addSeconds(5), new SendNewSchoolStaffEmail([
            'email' => $schoolStaff->email,
            'full_name' => "{$schoolStaff->first_name} {$schoolStaff->middle_name} {$schoolStaff->last_name}",
            'school' => $schoolStaff->school->name,
            'role' => $schoolStaff->role,
            'password' => $password,
        ]));
    }
}
