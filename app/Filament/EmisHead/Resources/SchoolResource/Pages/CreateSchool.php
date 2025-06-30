<?php

namespace App\Filament\EmisHead\Resources\SchoolResource\Pages;

use App\Actions\SchoolMetric\CreateSchoolMetricAction;
use App\Actions\SchoolStaff\CreateSchoolStaffAction;
use App\Filament\EmisHead\Resources\SchoolResource;
use App\InfrastructureProviders\Internal\CipherClient;
use App\Jobs\Notifications\Onboarding\SendNewSchoolStaffNotificationJob;
use Filament\Resources\Pages\CreateRecord;

class CreateSchool extends CreateRecord
{
    protected static string $resource = SchoolResource::class;

    protected static bool $canCreateAnother = false;

    private array $schoolStaffData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->getSchoolDetails();
        unset($data['school_admin_first_name']);
        unset($data['school_admin_middle_name']);
        unset($data['school_admin_last_name']);
        unset($data['school_admin_email']);
        unset($data['school_admin_phone']);

        return $data;
    }

    public function afterCreate(): void
    {
        $createSchoolStaffAction = app(CreateSchoolStaffAction::class);
        $createSchoolMetricsAction = app(CreateSchoolMetricAction::class);

        $this->schoolStaffData['school_id'] = $this->record->id;
        $createdSchoolStaff = $createSchoolStaffAction->execute(
            array_merge([
                'password' => CipherClient::hash($this->schoolStaffData['phone_number']),
            ], $this->schoolStaffData)
        );

        $createSchoolMetricsAction->execute([
            'school_id' => $this->record->id,
        ]);

        dispatch(
            new SendNewSchoolStaffNotificationJob([
                'email' => $createdSchoolStaff->email,
                'full_name' => "{$createdSchoolStaff->first_name} {$createdSchoolStaff->middle_name} {$createdSchoolStaff->last_name}",
                'role' => $createdSchoolStaff->role,
                'password' => $this->schoolStaffData['password'],
            ])
        );
    }

    private function getSchoolDetails(): void
    {
        $randomPassword = generateRandomString();
        $this->schoolStaffData = [
            'first_name' => $this->data['school_admin_first_name'],
            'middle_name' => $this->data['school_admin_middle_name'],
            'last_name' => $this->data['school_admin_last_name'],
            'email' => $this->data['school_admin_email'],
            'phone_number' => $this->data['school_admin_phone'],
            'password' => $randomPassword,
            'role' => 'admin',
        ];
    }
}
