<?php

namespace App\Filament\EmisHead\Resources\RequestResource\Pages;

use App\Filament\EmisHead\Resources\RequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequest extends CreateRecord
{
    protected static string $resource = RequestResource::class;

    protected static bool $canCreateAnother = false;
}
