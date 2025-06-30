<?php

namespace App\Filament\EmisHead\Resources\SchoolResource\Pages;

use App\Filament\EmisHead\Resources\SchoolResource;
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
                ->url(fn (): string => "/emisHead/schools/{$this->record->id}/teacher"),
            Actions\Action::make('learner')
                ->label(__('View all Student'))
                ->url(fn (): string => "/emisHead/schools/{$this->record->id}/student"),
        ];
    }
}
