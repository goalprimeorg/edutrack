<?php

namespace App\Filament\EmisHead\Resources\StudentResource\Pages;

use App\Filament\EmisHead\Resources\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected static bool $canCreateAnother = false;
}
