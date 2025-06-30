<?php

namespace App\Filament\SuperAdmin\Resources\SchoolStoreResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolStore extends CreateRecord
{
    protected static string $resource = SchoolStoreResource::class;

    protected static bool $canCreateAnother = false;
}
