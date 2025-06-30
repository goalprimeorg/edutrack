<?php

namespace App\Filament\EmisHead\Resources;

use App\Enums\EmisStatus;
use App\Filament\EmisHead\Resources\EmisResource\Pages;
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

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Forms\Components\Hidden::make('status')
                    ->default(EmisStatus::Active->value),
                Forms\Components\Select::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options(\App\Models\State::pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->relationship('localGovernmentArea', 'name', function ($query, Forms\Get $get) {
                        $stateId = $get('state_id');
                        if ($stateId) {
                            $query->where('state_id', $stateId);
                        }
                    })
                    ->searchable()
                    ->required(),
          
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full name')
                    ->default(function (Emis $model) {
                        return $model->first_name.' '.$model->middle_name.' '.$model->last_name;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('email address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->searchable(),
                //                Tables\Columns\TextColumn::make('status')
                //                    ->badge(),
            ])
            ->filters([
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
            'view' => Pages\ViewEmis::route('/{record}/view'),
            'edit' => Pages\EditEmis::route('/{record}/edit'),
        ];
    }
}
