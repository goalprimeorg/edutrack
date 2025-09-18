<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\ItemResource\Pages;
use App\Models\Item;
use App\Models\RequestType;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Partner';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $stateOptions = $isSuperAdmin
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id');

        return $form->schema([
            Forms\Components\Hidden::make('partner_id')
                ->default($user->id)
                ->required(),

            // State selection
            Forms\Components\Select::make('state_id')
                ->label(__('State'))
                ->options($stateOptions)
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('local_government_area_id', null))
                ->visible($isSuperAdmin),

            // LGA selection depends on state
            Forms\Components\Select::make('local_government_area_id')
                ->label(__('LGA'))
                ->options(function (Forms\Get $get) use ($user, $isSuperAdmin) {
                    if (! $isSuperAdmin) {
                        return LocalGovernmentArea::where('state_id', $user->state_id)->pluck('name', 'id');
                    }
                    if (! $get('state_id')) {
                        return [];
                    }
                    return LocalGovernmentArea::where('state_id', $get('state_id'))->pluck('name', 'id');
                })
                ->searchable()
                ->required()
                ->disabled(fn (Forms\Get $get) => $isSuperAdmin && ! $get('state_id'))
                ->dehydrated(),

            // Item name
            Forms\Components\TextInput::make('name')
                ->label(__('Item Name'))
                ->required(),

            // Request Resource Type
            Forms\Components\Select::make('request_resource_type')
                ->label(__('Resource Type'))
                ->options(RequestType::pluck('name', 'id'))
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user, $isSuperAdmin) {
                if (! $isSuperAdmin) {
                    $query->where('state_id', $user->state_id);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->label(__('LGA'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Item Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('requestType.name')
                    ->label(__('Resource Type'))
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state_id')
                    ->label(__('State'))
                    ->options(fn () => $isSuperAdmin
                        ? State::pluck('name', 'id')
                        : State::where('id', Auth::user()->state_id)->pluck('name', 'id'))
                    ->visible($isSuperAdmin),

                Tables\Filters\SelectFilter::make('local_government_area_id')
                    ->label(__('LGA'))
                    ->options(fn () => $isSuperAdmin
                        ? LocalGovernmentArea::pluck('name', 'id')
                        : LocalGovernmentArea::where('state_id', Auth::user()->state_id)->pluck('name', 'id')),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
