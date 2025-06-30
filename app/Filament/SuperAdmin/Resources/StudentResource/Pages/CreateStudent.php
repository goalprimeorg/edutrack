<?php

namespace App\Filament\SuperAdmin\Resources\StudentResource\Pages;

use App\Filament\SuperAdmin\Resources\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected static bool $canCreateAnother = false;
}
