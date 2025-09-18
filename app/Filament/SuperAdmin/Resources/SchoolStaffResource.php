<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Enums\SchoolStaffRole;
use App\Models\School;
use App\Models\SchoolStaff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolStaffResource extends Resource
{
    protected static ?string $model = SchoolStaff::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'School';

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
                    ->label(__('School'))
                    ->options(School::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('role')
                    ->options(SchoolStaffRole::toArray())
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('middle_name')
                    ->nullable(),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->unique('school_staff', 'email', ignoreRecord: true)
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Forms\Components\Select::make('is_staff_disabled')
                    ->label('Is Staff Disabled?')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->hiddenOn(['create', 'view']),
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
                Tables\Columns\TextColumn::make('role')
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
                Tables\Filters\SelectFilter::make('school_id')
                    ->options(School::all()->pluck('name', 'id')),
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
            'index' => \App\Filament\SuperAdmin\Resources\SchoolStaffResource\Pages\ListSchoolStaff::route('/'),
            'create' => \App\Filament\SuperAdmin\Resources\SchoolStaffResource\Pages\CreateSchoolStaff::route('/create'),
            'view' => \App\Filament\SuperAdmin\Resources\SchoolStaffResource\Pages\ViewSchoolStaff::route('/{record}/view'),
            'edit' => \App\Filament\SuperAdmin\Resources\SchoolStaffResource\Pages\EditSchoolStaff::route('/{record}/edit'),
        ];
    }
}
