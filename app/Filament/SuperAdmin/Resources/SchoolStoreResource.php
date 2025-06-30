<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\SchoolStoreResource\Pages;
use App\Filament\SuperAdmin\Resources\SchoolStoreResource\RelationManagers;
use App\Models\Item;
use App\Models\School;
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
                Forms\Components\Select::make('state_id')
                ->label(__('State'))
                ->relationship('state', 'name')
                ->options(\App\Models\State::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('local_government_area_id', null); // Reset LGA
                }),
            Forms\Components\Select::make('local_government_area_id')
                ->label(__('Local Government Area'))
                ->options(function (Forms\Get $get) {
                    $stateId = $get('state_id');
                    if (!$stateId) {
                        return [];
                    }
                    $lgas = \App\Models\LocalGovernmentArea::where('state_id', $stateId)
                        ->pluck('name', 'id')
                        ->toArray();
                    return $lgas;
                })
                ->searchable()
                ->required()
                ->disabled(function (Forms\Get $get) {
                    return !$get('state_id');
                })
                ->dehydrated(),
                Forms\Components\Select::make('school_id')
                    ->label('School')
                    ->options(School::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('item_id')
                    ->label('Item')
                    ->options(Item::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('current_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('state.name')
                ->label(__('State'))
                ->searchable(),
            Tables\Columns\TextColumn::make('localGovernmentArea.name')
                ->searchable(),
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
