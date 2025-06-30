<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Enums\EmisStatus;
use App\Filament\SuperAdmin\Resources\EmisResource\Pages;
use App\Models\Emis;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmisResource extends Resource
{
    protected static ?string $model = Emis::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Emis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('middle_name')
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->unique('emis', 'email', ignoreRecord: true)
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Forms\Components\Hidden::make('status')
                    ->default(EmisStatus::Active->value)
                    ->required(),
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
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
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
            'index' => Pages\ListEmis::route('/'),
            'create' => Pages\CreateEmis::route('/create'),
            'view' => Pages\ViewEmis::route('/{record}'),
            'edit' => Pages\EditEmis::route('/{record}/edit'),
        ];
    }
}
