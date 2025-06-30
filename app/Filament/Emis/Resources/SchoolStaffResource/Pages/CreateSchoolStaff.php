<?php

namespace App\Filament\Emis\Resources\SchoolStaffResource\Pages;

use App\Filament\Emis\Resources\SchoolStaffResource;
use App\InfrastructureProviders\Internal\CipherClient;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolStaff extends CreateRecord
{
    protected static string $resource = SchoolStaffResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $password = generateRandomString();
        $data['password'] = CipherClient::hash($data['phone_number']);

        return $data;
    }
}
