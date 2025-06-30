<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Models\Classroom;
use App\Models\School;
use App\Models\SchoolStaff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

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
                Forms\Components\Select::make('form_teacher_id')
                    ->label(__('Form Teacher'))
                    ->options(function (?string $state, Forms\Get $get) {
                        $schoolId = $get('school_id');
                        if (! $schoolId) {
                            return;
                        }

                        return SchoolStaff::where('school_id', $schoolId)->pluck('first_name', 'id');
                    })
                    ->searchable(),
                Forms\Components\TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('formTeacher.first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school_id')
                    ->label(__('School'))
                    ->options(School::all()->pluck('name', 'id'))
                    ->searchable(),
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
            'index' => \App\Filament\SuperAdmin\Resources\ClassroomResource\Pages\ListClassrooms::route('/'),
            'create' => \App\Filament\SuperAdmin\Resources\ClassroomResource\Pages\CreateClassroom::route('/create'),
            'edit' => \App\Filament\SuperAdmin\Resources\ClassroomResource\Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
