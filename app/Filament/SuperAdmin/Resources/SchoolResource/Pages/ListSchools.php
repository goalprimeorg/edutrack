<?php

namespace App\Filament\SuperAdmin\Resources\SchoolResource\Pages;

use App\Actions\LocalGovernmentArea\ListLocalGovernmentAreasAction;
use App\Filament\SuperAdmin\Resources\SchoolResource;
use App\Actions\Import\SchoolImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Table;

class ListSchools extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('download')
                ->url('/school/export-excel-file')
                ->icon('heroicon-o-arrow-down-tray'),
                Actions\Action::make('import')
                ->form([
                    FileUpload::make('schools')
                ])
                ->action(function (array $data)  {
                    $import = app(SchoolImportAction::class);
                    $import->execute($data);
                })
                ->icon('heroicon-o-arrow-up-tray'),
        ];
    }

    public function table(\Filament\Tables\Table $table): Table
    {
        $listLocalGovernmentAreasActions = app(ListLocalGovernmentAreasAction::class);

        $localGovernmentAreas = $listLocalGovernmentAreasActions->execute();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('state_id')
                ->label(__('State'))
                ->relationship('state', 'name')
                ->options(\App\Models\State::pluck('name', 'id')),
                SelectFilter::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->options($localGovernmentAreas->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
