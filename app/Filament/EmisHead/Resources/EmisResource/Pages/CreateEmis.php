<?php

namespace App\Filament\EmisHead\Resources\EmisResource\Pages;

use App\Filament\EmisHead\Resources\EmisResource;
use App\InfrastructureProviders\Internal\CipherClient;
use Filament\Resources\Pages\CreateRecord;

class CreateEmis extends CreateRecord
{
    protected static string $resource = EmisResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $password = generateRandomString();
        //        $data['password'] = CipherClient::hash($password);
        $data['password'] = CipherClient::hash($data['phone_number']);

        return $data;
    }
}
