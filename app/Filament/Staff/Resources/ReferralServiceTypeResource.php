<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\ReferralServiceTypeResource\Pages;
use App\Models\ReferralServiceType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferralServiceTypeResource extends Resource
{
    protected static ?string $model = ReferralServiceType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Referral';

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
            'index' => Pages\ListReferralServiceTypes::route('/'),
            'create' => Pages\CreateReferralServiceType::route('/create'),
            'view' => Pages\ViewReferralServiceType::route('/{record}'),
            'edit' => Pages\EditReferralServiceType::route('/{record}/edit'),
        ];
    }
}
