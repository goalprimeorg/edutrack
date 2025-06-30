<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\IncidentTypeResource\Pages;
use App\Models\IncidentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IncidentTypeResource extends Resource
{
    protected static ?string $model = IncidentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'Incident';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncidentTypes::route('/'),
            'create' => Pages\CreateIncidentType::route('/create'),
            'view' => Pages\ViewIncidentType::route('/{record}'),
            'edit' => Pages\EditIncidentType::route('/{record}/edit'),
        ];
    }
}
