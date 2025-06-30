<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\StudentResource\Pages;
use App\Models\Classroom;
use App\Models\School;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'School';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label(__('School'))
                    ->options(School::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('current_classroom_id')
                    ->label(__('Classroom'))
                    ->searchable()
                    ->options(function (Forms\Get $get) {
                        $schoolId = $get('school_id');
                        if (! $schoolId) {
                            return;
                        }

                        return Classroom::where('school_id', $schoolId)->pluck('name', 'id');
                    })
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\TextInput::make('registration_number')
                    ->required(),
                Forms\Components\TextInput::make('guardian_first_name')
                    ->required(),
                Forms\Components\TextInput::make('guardian_last_name')
                    ->required(),
                Forms\Components\TextInput::make('guardian_phone_number')
                    ->tel()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currentClassroom.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guardian_first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guardian_last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guardian_phone_number')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
