<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\ShipmentResource\Pages;
use App\Models\Inventory;
use App\Models\Partner;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Partner';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('inventory_id')
                    ->label(__('Inventory Item'))
                    ->options(Inventory::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Hidden::make('partner_from_id')
                    ->default(auth()->user()->id)
                    ->required(),
                Forms\Components\Select::make('partner_to_id')
                    ->label(__('Send To'))
                    ->searchable()
                    ->options(Partner::all()->pluck('org_name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('inventory.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('partnerFrom.org_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('partnerTo.org_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
            ])
            ->query(function () {
                return Shipment::where('partner_from_id', auth()->user()->id)
                    ->orWhere('partner_to_id', auth()->user()->id);
            })
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'view' => Pages\ViewShipment::route('/{record}'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
