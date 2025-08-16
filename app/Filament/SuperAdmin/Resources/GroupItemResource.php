<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\GroupItemResource\Pages;
use App\Filament\SuperAdmin\Resources\GroupItemResource\RelationManagers;
use App\Models\GroupItem;
use Filament\Forms;
use App\Models\Student;
use App\Models\Item;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupItemResource extends Resource
{
    protected static ?string $model = GroupItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Student')
                    ->options(Student::pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->label('Group Name')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Remark')
                    ->nullable(),

                    Forms\Components\Repeater::make('details')
                    ->label('Items in Group')
                    ->relationship('details')
                    ->schema([
                        Forms\Components\Select::make('item_id')
                            ->label('Item')
                            ->relationship('item', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required(),
                    ])
                    ->createItemButtonLabel('Add Item')
                    ->defaultItems(1)
                    ->minItems(1)
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')->label('Student'),
                Tables\Columns\TextColumn::make('name')->label('Group Name'),
                Tables\Columns\TextColumn::make('details_count')
                    ->counts('details')
                    ->label('Total Items'),
                Tables\Columns\TextColumn::make('created_at')->date(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupItems::route('/'),
            'create' => Pages\CreateGroupItem::route('/create'),
            'edit' => Pages\EditGroupItem::route('/{record}/edit'),
        ];
    }

    
}
