<?php

namespace App\Filament\Emis\Resources;

use App\Filament\Emis\Resources\ClassroomResource\Pages;
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

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Schools';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label(__('School'))
                    ->options(function () {
                        return School::where('local_government_area_id', auth()->user()->local_government_area_id)
                            ->pluck('name', 'id');
                    })
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
                    ->label(__('Form Teacher'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Class Name'))
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
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'view' => Pages\ViewClassroom::route('/{record}'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
