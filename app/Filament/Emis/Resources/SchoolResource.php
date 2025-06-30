<?php

namespace App\Filament\Emis\Resources;

use App\Filament\Emis\Resources\SchoolResource\Pages;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Schools';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Hidden::make('local_government_area_id')
                    ->default(auth()->user()->local_government_area_id)
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
            ])
            ->query(function () {
                return School::where('local_government_area_id', auth()->user()->local_government_area_id);
            })
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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'view' => Pages\ViewSchool::route('/{record}'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}
