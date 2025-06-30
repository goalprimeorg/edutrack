<?php

namespace App\Filament\SuperAdmin\Resources\PartnerResource\Pages;

use App\Filament\SuperAdmin\Resources\PartnerResource;
use App\InfrastructureProviders\Internal\CipherClient;
use Filament\Resources\Pages\CreateRecord;

class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = CipherClient::hash($data['phone_number']);

        return $data;
    }
}
