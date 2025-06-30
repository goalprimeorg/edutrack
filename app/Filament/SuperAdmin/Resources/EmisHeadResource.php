<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Models\EmisHead;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmisHeadResource extends Resource
{
    protected static ?string $model = EmisHead::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Emis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->unique('emis_heads', 'email', ignoreRecord: true)
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
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
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->visibleOn(['edit']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
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
            'index' => \App\Filament\SuperAdmin\Resources\EmisHeadResource\Pages\ListEmisHeads::route('/'),
            'create' => \App\Filament\SuperAdmin\Resources\EmisHeadResource\Pages\CreateEmisHead::route('/create'),
            'edit' => \App\Filament\SuperAdmin\Resources\EmisHeadResource\Pages\EditEmisHead::route('/{record}/edit'),
        ];
    }
}
