<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\StudentResource\Pages;
use App\Models\Classroom;
use App\Models\School;
use App\Models\Student;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'School';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $stateOptions = $isSuperAdmin 
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id'); 

        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label(__('School'))
                    ->options(function () use ($user, $isSuperAdmin) {
                        $query = School::query();
                        if (!$isSuperAdmin) {
                            $query->where('state_id', $user->state_id);
                        }
                        return $query->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('current_classroom_id', null);
                    }),
                Forms\Components\Select::make('current_classroom_id')
                    ->label(__('Classroom'))
                    ->searchable()
                    ->options(function (Forms\Get $get) {
                        $schoolId = $get('school_id');
                        if (! $schoolId) {
                            return [];
                        }
                        return Classroom::where('school_id', $schoolId)->pluck('name', 'id');
                    })
                    ->required()
                    ->disabled(fn (Forms\Get $get) => ! $get('school_id')),
                Forms\Components\Select::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options($stateOptions)
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('local_government_area_id', null);
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
                    ->dehydrated(),
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
        $user = Auth::user();
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
                Tables\Columns\TextColumn::make('currentClassroom.name')
                    ->label(__('Classroom'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}