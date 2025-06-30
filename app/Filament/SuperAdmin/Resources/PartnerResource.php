<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Enums\PartnerType;
use App\Filament\SuperAdmin\Resources\PartnerResource\Pages;
use App\Models\LocalGovernmentArea;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Partner';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('org_name')
                    ->label('Organisation Name')
                    ->required(),
                Forms\Components\TextInput::make('org_acronym')
                    ->label('Organisation Acronym')
                    ->required(),
                Forms\Components\Select::make('org_type')
                    ->options(PartnerType::toArray())
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('middle_name'),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->unique('partners', 'email', ignoreRecord: true)
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Forms\Components\Section::make([
                    Forms\Components\Repeater::make('area_of_lga')
                        ->label('Area of Activities')
                        ->schema([
                            Forms\Components\Select::make('local_government_area')
                                ->options(LocalGovernmentArea::all()->pluck('name', 'id'))
                                ->required(),
                        ]),
                ]),
                Forms\Components\Section::make([
                    Forms\Components\Repeater::make('services')
                        ->schema([
                            Forms\Components\TextInput::make('service')
                        ]),
                ]),
                Forms\Components\TextInput::make('password')
                    ->visibleOn(['edit'])
                    ->password()
                    ->revealable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('org_name')
                    ->label('Organization Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'view' => Pages\ViewPartner::route('/{record}'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
