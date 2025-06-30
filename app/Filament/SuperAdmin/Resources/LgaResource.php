<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\LgaResource\Pages;
use App\Filament\SuperAdmin\Resources\LgaResource\RelationManagers;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LgaResource extends Resource
{
    protected static ?string $model = LocalGovernmentArea::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('state_id')
                    ->relationship('state', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true, table: 'local_government_areas', column: 'name'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('state.name')->label('State'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')->relationship('state', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLgas::route('/'),
            'create' => Pages\CreateLga::route('/create'),
            'edit' => Pages\EditLga::route('/{record}/edit'),
        ];
    }
}
