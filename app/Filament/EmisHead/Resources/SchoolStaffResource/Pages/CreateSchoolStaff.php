<?php

namespace App\Filament\EmisHead\Resources\SchoolStaffResource\Pages;

use App\Filament\EmisHead\Resources\SchoolStaffResource;
use App\InfrastructureProviders\Internal\CipherClient;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolStaff extends CreateRecord
{
    protected static string $resource = SchoolStaffResource::class;

    protected static bool $canCreateAnother = false;

    private array $schoolStaffData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = CipherClient::hash($data['phone_number']);

        return $data;
    }
}
