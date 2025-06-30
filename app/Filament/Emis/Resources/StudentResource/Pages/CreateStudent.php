<?php

namespace App\Filament\Emis\Resources\StudentResource\Pages;

use App\Filament\Emis\Resources\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected static bool $canCreateAnother = false;
}
