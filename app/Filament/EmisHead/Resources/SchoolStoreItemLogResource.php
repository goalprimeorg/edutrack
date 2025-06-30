<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\SchoolStoreItemLogResource\Pages;
use App\Filament\EmisHead\Resources\SchoolStoreItemLogResource\RelationManagers;
use App\Models\School;
use App\Models\SchoolStaff;
use App\Models\SchoolStoreItem;
use App\Models\SchoolStoreItemLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolStoreItemLogResource extends Resource
{
    protected static ?string $model = SchoolStoreItemLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationGroup = "School";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label('School')
                    ->options(School::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('school_store_item_id')
                    ->label('Store Item')
                    ->options(SchoolStoreItem::all()->pluck('item.name', 'id'))
                    ->required(),
                Forms\Components\Select::make('school_staff_id')
                    ->label('Staff')
                    ->options(SchoolStaff::all()->pluck('first_name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('quantity_before')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('quantity_change')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('quantity_after')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('operation_type')
                    ->required(),
                Forms\Components\Textarea::make('remark')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('schoolStoreItem..item.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('schoolStaff.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity_before')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_change')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_after')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('operation_type')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSchoolStoreItemLogs::route('/'),
            'create' => Pages\CreateSchoolStoreItemLog::route('/create'),
            'view' => Pages\ViewSchoolStoreItemLog::route('/{record}'),
            'edit' => Pages\EditSchoolStoreItemLog::route('/{record}/edit'),
        ];
    }
}
