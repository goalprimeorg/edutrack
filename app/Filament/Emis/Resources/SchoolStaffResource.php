<?php

namespace App\Filament\Emis\Resources;

use App\Enums\SchoolStaffRole;
use App\Filament\Emis\Resources\SchoolStaffResource\Pages;
use App\Models\School;
use App\Models\SchoolStaff;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SchoolStaffResource extends Resource
{
    protected static ?string $model = SchoolStaff::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Schools';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $stateOptions = $isSuperAdmin 
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id'); // Assuming user has state_id

        return $form
            ->schema([
                Forms\Components\Select::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options($stateOptions)
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('local_government_area_id', null);
                        $set('school_id', null);
                    })
                    ->visible($isSuperAdmin), // Only super-admin sees state filter
                Forms\Components\Select::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->options(function (Forms\Get $get) use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        $stateId = $get('state_id');
                        if (!$stateId) {
                            return [];
                        }
                        return LocalGovernmentArea::where('state_id', $stateId)
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->disabled(function (Forms\Get $get) use ($isSuperAdmin) {
                        return $isSuperAdmin && !$get('state_id');
                    })
                    ->dehydrated()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('school_id', null);
                    }),
                Forms\Components\Select::make('school_id')
                    ->label(__('School'))
                    ->options(function (Forms\Get $get) use ($user, $isSuperAdmin) {
                        $query = School::query();
                        if (!$isSuperAdmin) {
                            $query->where('state_id', $user->state_id);
                        } elseif ($lgaId = $get('local_government_area_id')) {
                            $query->where('local_government_area_id', $lgaId);
                        }
                        return $query->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('role')
                    ->options(SchoolStaffRole::toArray())
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('middle_name'),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->unique('school_staff', 'email', ignoreRecord: true)
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {    $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user, $isSuperAdmin) {
                if (!$isSuperAdmin) {
                    $query->whereHas('school', fn ($q) => $q->where('state_id', $user->state_id));
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->label(__('School'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('school.state.name')
                    ->label(__('State'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('school.localGovernmentArea.name')
                    ->label(__('Local Government Area'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_login_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school_id')
                    ->label(__('School'))
                    ->relationship('school', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return School::where('state_id', $user->state_id)->pluck('name', 'id');
                        }
                        return School::pluck('name', 'id');
                    })
                    ->searchable(),
                Tables\Filters\SelectFilter::make('state_id')
                    ->label(__('State'))
                    ->relationship('school.state', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return State::where('id', $user->state_id)->pluck('name', 'id');
                        }
                        return State::pluck('name', 'id');
                    })
                    ->visible($isSuperAdmin), // Only super-admin sees state filter
                Tables\Filters\SelectFilter::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->relationship('school.localGovernmentArea', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        return LocalGovernmentArea::pluck('name', 'id');
                    })
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSchoolStaff::route('/'),
            'create' => Pages\CreateSchoolStaff::route('/create'),
            'view' => Pages\ViewSchoolStaff::route('/{record}'),
            'edit' => Pages\EditSchoolStaff::route('/{record}/edit'),
        ];
    }
}