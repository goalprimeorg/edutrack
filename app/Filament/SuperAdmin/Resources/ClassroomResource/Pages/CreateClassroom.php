<?php

namespace App\Filament\SuperAdmin\Resources\ClassroomResource\Pages;

use App\Filament\SuperAdmin\Resources\ClassroomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClassroom extends CreateRecord
{
    protected static string $resource = ClassroomResource::class;

    protected static bool $canCreateAnother = false;
}
