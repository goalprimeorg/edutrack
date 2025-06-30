<?php

namespace App\Filament\Emis\Resources\ClassroomResource\Pages;

use App\Filament\Emis\Resources\ClassroomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClassroom extends CreateRecord
{
    protected static string $resource = ClassroomResource::class;

    protected static bool $canCreateAnother = false;
}
