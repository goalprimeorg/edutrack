<?php

namespace App\Filament\Staff\Resources\RequestResource\Pages;

use App\Filament\Staff\Resources\RequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequest extends CreateRecord
{
    protected static string $resource = RequestResource::class;

    protected static bool $canCreateAnother = false;
}
