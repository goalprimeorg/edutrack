<?php


namespace App\Filament\EmisHead\Resources;

use App\Filament\SuperAdmin\Resources\StudentAttendanceMetaResource\Pages;
use App\Models\StudentAttendanceMeta;
use App\Models\School;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceMetaResource extends Resource
{
    protected static ?string $model = StudentAttendanceMeta::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'School';

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
                        $set('classroom_id', null);
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
                        $set('classroom_id', null);
                    }),
                Forms\Components\Select::make('school_id')
                    ->relationship('school', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('classroom_id', null);
                        $set('marked_by_school_staff_id', null);
                    })
                    ->options(function (Forms\Get $get) use ($user, $isSuperAdmin) {
                        $query = School::orderBy('name');
                        if (!$isSuperAdmin) {
                            $query->where('state_id', $user->state_id);
                        } elseif ($lgaId = $get('local_government_area_id')) {
                            $query->where('local_government_area_id', $lgaId);
                        }
                        $schools = $query->pluck('name', 'id');
                        return $schools->isEmpty() ? ['No schools available'] : $schools;
                    }),
                Forms\Components\Select::make('classroom_id')
                    ->relationship('classroom', 'name', function ($query, callable $get) {
                        $schoolId = $get('school_id');
                        return $schoolId ? $query->where('school_id', $schoolId) : $query->whereRaw('1 = 0');
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(fn ($get) => ! $get('school_id'))
                    ->options(function ($get) {
                        $schoolId = $get('school_id');
                        if (! $schoolId) {
                            return ['Select a school first'];
                        }
                        return \App\Models\Classroom::where('school_id', $schoolId)
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray() ?: ['No classrooms available'];
                    }),
                Forms\Components\Select::make('marked_by_school_staff_id')
                    ->relationship('markedBy', 'first_name', function ($query, callable $get) {
                        $schoolId = $get('school_id');
                        return $schoolId ? $query->where('school_id', $schoolId) : $query->whereRaw('1 = 0');
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->disabled(fn ($get) => ! $get('school_id'))
                    ->options(function ($get) {
                        $schoolId = $get('school_id');
                        if (! $schoolId) {
                            return ['Select a school first'];
                        }
                        return \App\Models\SchoolStaff::where('school_id', $schoolId)
                            ->orderBy('first_name')
                            ->get()
                            ->mapWithKeys(fn ($staff) => [$staff->id => "{$staff->first_name} {$staff->last_name}"])
                            ->toArray() ?: ['No staff available'];
                    }),
                Forms\Components\DatePicker::make('date_of_attendance')
                    ->required()
                    ->maxDate(now()),
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('markedBy.first_name')
                    ->label('Marked By')
                    ->getStateUsing(fn ($record) => $record->markedBy ? "{$record->markedBy->first_name} {$record->markedBy->last_name}" : null)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_attendance')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->label(__('Local Government Area'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('school')
                    ->relationship('school', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return School::where('state_id', $user->state_id)->pluck('name', 'id');
                        }
                        return School::pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('classroom')
                    ->relationship('classroom', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return State::where('id', $user->state_id)->pluck('name', 'id');
                        }
                        return State::pluck('name', 'id');
                    })
                    ->visible($isSuperAdmin), // Only super-admin sees state filter
                Tables\Filters\SelectFilter::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->relationship('localGovernmentArea', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        return LocalGovernmentArea::pluck('name', 'id');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentAttendanceMetas::route('/'),
            'create' => Pages\CreateStudentAttendanceMeta::route('/create'),
            'edit' => Pages\EditStudentAttendanceMeta::route('/{record}/edit'),
        ];
    }
}