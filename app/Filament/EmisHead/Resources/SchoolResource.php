<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\SchoolResource\Pages;
use App\Models\LocalGovernmentArea;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'School';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->options(LocalGovernmentArea::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('school_admin_first_name')
                    ->label(__('School Contact Person First Name'))
                    ->visibleOn('create')
                    ->required(),
                Forms\Components\TextInput::make('school_admin_middle_name')
                    ->label(__('School Contact Person Middle Name'))
                    ->visibleOn('create')
                    ->nullable(),
                Forms\Components\TextInput::make('school_admin_last_name')
                    ->label(__('School Contact Person Last Name'))
                    ->visibleOn('create')
                    ->required(),
                Forms\Components\TextInput::make('school_admin_email')
                    ->unique('school_staff', 'email', ignoreRecord: true)
                    ->visibleOn('create')
                    ->email()
                    ->label(__('School Contact Person Email'))
                    ->required(),
                Forms\Components\TextInput::make('school_admin_phone')
                    ->label(__('School Contact Person Phone'))
                    ->visibleOn('create')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('School Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('local_government_area_id')
                    ->label('Local Government Area')
                    ->options(LocalGovernmentArea::all()->pluck('name', 'id'))
                    ->searchable(),
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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'view' => Pages\ViewSchool::route('/{record}/view'),
            'teacher' => Pages\ViewTeacherTable::route('/{record}/teacher'),
            'student' => Pages\ListStudentTable::route('/{record}/student'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}
