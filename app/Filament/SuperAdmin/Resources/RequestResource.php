<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\RequestResource\Pages;
use App\Enums\RequestPriorityStatus;
use App\Models\Request;
use App\Models\Item;
use App\Models\LocalGovernmentArea;
use App\Models\State;
use App\Models\School;
use App\Models\RequestType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $stateOptions = $isSuperAdmin
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id');

        return $form
            ->schema([
                Forms\Components\Hidden::make('partner_id')
                    ->default($user->id)
                    ->required(),

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

                Forms\Components\Select::make('item_id')
                    ->label(__('Item'))
                    ->options(Item::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                    Forms\Components\Select::make('resource_type')
                    ->label(__('Resource Type'))
                    ->options(RequestType::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('requested_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                    Forms\Components\Select::make('priority')
                    ->options(RequestPriorityStatus::toArray())
                    ->label('Priority Status')
                    ->required(),
                Forms\Components\Hidden::make('status')
                    ->default('pending'),

                Forms\Components\Textarea::make('remarks')
                    ->maxLength(500)
                    ->columnSpanFull(),
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
                return $query;
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
                    Tables\Columns\TextColumn::make('school.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->label(__('Resource Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('partner.name')
                    ->label(__('Partner'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (! $isSuperAdmin) {
                            return State::where('id', $user->state_id)->pluck('name', 'id');
                        }
                        return State::pluck('name', 'id');
                    })
                    ->visible($isSuperAdmin),

                Tables\Filters\SelectFilter::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->relationship('localGovernmentArea', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (! $isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        return LocalGovernmentArea::pluck('name', 'id');
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Add bulk actions if needed
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'view' => Pages\ViewRequest::route('/{record}'),
        ];
    }
}
