<?php

namespace App\Filament\EmisHead\Resources\EmisResource\Pages;

use App\Actions\SuspendEmisAction;
use App\Filament\EmisHead\Resources\EmisResource;
use App\Models\Emis;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmis extends ViewRecord
{
    protected static string $resource = EmisResource::class;

    public function getHeaderActions(): array
    {
        return [
            Actions\Action::make('suspend')
                ->requiresConfirmation()
                ->action(fn (Emis $emis) => SuspendEmisAction::execute($emis->id)),
        ];
    }
}
