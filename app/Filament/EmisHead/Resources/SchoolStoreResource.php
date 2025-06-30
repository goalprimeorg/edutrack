<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\SchoolStoreResource\Pages;
use App\Filament\EmisHead\Resources\SchoolStoreResource\RelationManagers;
use App\Models\SchoolStore;
use App\Models\SchoolStoreItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class SchoolStoreResource extends Resource
{
    protected static ?string $model = SchoolStoreItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = "School";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('school_id')
//                    ->required(),
//                Forms\Components\TextInput::make('item_id')
//                    ->required(),
//                Forms\Components\TextInput::make('current_quantity')
//                    ->required()
//                    ->numeric()
//                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_quantity')
                    ->numeric()
                    ->sortable(),
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
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSchoolStores::route('/'),
            'create' => Pages\CreateSchoolStore::route('/create'),
            'view' => Pages\ViewSchoolStore::route('/{record}'),
            'edit' => Pages\EditSchoolStore::route('/{record}/edit'),
        ];
    }
}
