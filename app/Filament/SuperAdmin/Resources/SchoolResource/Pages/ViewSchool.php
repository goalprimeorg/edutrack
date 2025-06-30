<?php

namespace App\Filament\SuperAdmin\Resources\SchoolResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSchool extends ViewRecord
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('teacher')
                ->label(__('View all Teachers'))
                ->url(fn (): string => "/superAdmin/schools/{$this->data['id']}/staff"),

            Actions\Action::make('student')
                ->label(__('View all Students'))
                ->url(fn (): string => "/superAdmin/schools/{$this->data['id']}/student"),
        ];
    }
}
