<?php

namespace App\Filament\SuperAdmin\Resources\EmisHeadResource\Pages;

use App\Filament\SuperAdmin\Resources\EmisHeadResource;
use App\InfrastructureProviders\Internal\CipherClient;
use App\Notifications\SendPasswordMail;
use Filament\Resources\Pages\CreateRecord;

class CreateEmisHead extends CreateRecord
{
    protected static string $resource = EmisHeadResource::class;

    protected static bool $canCreateAnother = false;

    private string $password;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = CipherClient::hash($data['phone_number']);

        return $data;
    }

    protected function afterCreate()
    {
        //        $this->sendMail();
    }

    private function sendMail(): void
    {
        $name = $this->record->first_name.' '.$this->record->last_name;
        auth()->user()->notify(new SendPasswordMail(
            $name,
            $this->record->email,
            $this->password
        ));
    }
}
