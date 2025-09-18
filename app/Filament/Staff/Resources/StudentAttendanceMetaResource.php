<?php

namespace App\Filament\Staff\Resources;

use App\Filament\SuperAdmin\Resources\StudentAttendanceMetaResource\Pages;
use App\Models\StudentAttendanceMeta;
use App\Models\School;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use App\Models\Classroom;
use App\Models\SchoolStaff;
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
        $isSchoolStaff = !$isSuperAdmin && $user->school_id; // Assuming school staff have school_id

        $stateOptions = $isSuperAdmin 
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id'); // Assuming user has state_id

        $schoolOptions = $isSuperAdmin 
            ? School::orderBy('name')->pluck('name', 'id')
            : ($isSchoolStaff 
                ? School::where('id', $user->school_id)->pluck('name', 'id')
                : School::where('state_id', $user->state_id)->orderBy('name')->pluck('name', 'id'));

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
                    ->options(function (Forms\Get $get) use ($user, $isSuperAdmin, $isSchoolStaff) {
                        if ($isSchoolStaff) {
                            return LocalGovernmentArea::where('id', School::find($user->school_id)->local_government_area_id)
                                ->pluck('name', 'id');
                        }
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
                    })
                    ->visible(!$isSchoolStaff), // Hidden for school staff
                Forms\Components\Select::make('school_id')
                    ->relationship('school', 'name')
                    ->options($schoolOptions)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('classroom_id', null);
                        $set('marked_by_school_staff_id', null);
                    })
                    ->disabled($isSchoolStaff), // Fixed for school staff
                Forms\Components\Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->options(function (Forms\Get $get) use ($user, $isSchoolStaff) {
                        $schoolId = $get('school_id') ?: ($isSchoolStaff ? $user->school_id : null);
                        if (!$schoolId) {
                            return ['Select a school first'];
                        }
                        $query = Classroom::where('school_id', $schoolId)->orderBy('name');
                        if ($isSchoolStaff && $user->class_id) {
                            $query->where('id', $user->class_id);
                        }
                        return $query->pluck('name', 'id')->toArray() ?: ['No classrooms available'];
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(fn (Forms\Get $get) => ! $get('school_id') || ($isSchoolStaff && $user->class_id)),
                Forms\Components\Select::make('marked_by_school_staff_id')
                    ->relationship('markedBy', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->options(function (Forms\Get $get) use ($user, $isSchoolStaff) {
                        $schoolId = $get('school_id') ?: ($isSchoolStaff ? $user->school_id : null);
                        if (!$schoolId) {
                            return ['Select a school first'];
                        }
                        return SchoolStaff::where('school_id', $schoolId)
                            ->orderBy('first_name')
                            ->get()
                            ->mapWithKeys(fn ($staff) => [$staff->id => "{$staff->first_name} {$staff->last_name}"])
                            ->toArray() ?: ['No staff available'];
                    })
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->disabled(fn (Forms\Get $get) => ! $get('school_id')),
                Forms\Components\DatePicker::make('date_of_attendance')
                    ->required()
                    ->maxDate(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();
        $isSchoolStaff = !$isSuperAdmin && $user->school_id; // Assuming school staff have school_id

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user, $isSuperAdmin, $isSchoolStaff) {
                if ($isSchoolStaff) {
                    $query->where('school_id', $user->school_id);
                    if ($user->class_id) {
                        $query->where('classroom_id', $user->class_id);
                    }
                } elseif (!$isSuperAdmin) {
                    $query->whereHas('school', fn ($q) => $q->where('state_id', $user->state_id));
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->label(__('School'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label(__('Classroom'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('markedBy.first_name')
                    ->label('Marked By')
                    ->getStateUsing(fn ($record) => $record->markedBy ? "{$record->markedBy->first_name} {$record->markedBy->last_name}" : null)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_attendance')
                    ->label(__('Date'))
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
                    ->options(function () use ($user, $isSuperAdmin, $isSchoolStaff) {
                        if ($isSchoolStaff) {
                            return School::where('id', $user->school_id)->pluck('name', 'id');
                        }
                        if (!$isSuperAdmin) {
                            return School::where('state_id', $user->state_id)->pluck('name', 'id');
                        }
                        return School::pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->visible(!$isSchoolStaff), // Hidden for school staff
                Tables\Filters\SelectFilter::make('classroom')
                    ->relationship('classroom', 'name')
                    ->options(function () use ($user, $isSchoolStaff) {
                        if ($isSchoolStaff) {
                            $query = Classroom::where('school_id', $user->school_id);
                            if ($user->class_id) {
                                $query->where('id', $user->class_id);
                            }
                            return $query->pluck('name', 'id');
                        }
                        return Classroom::pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->visible(!$isSchoolStaff || !$user->class_id), // Hidden for staff with class_id
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
                    ->options(function () use ($user, $isSuperAdmin, $isSchoolStaff) {
                        if ($isSchoolStaff) {
                            return LocalGovernmentArea::where('id', School::find($user->school_id)->local_government_area_id)
                                ->pluck('name', 'id');
                        }
                        if (!$isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        return LocalGovernmentArea::pluck('name', 'id');
                    })
                    ->visible(!$isSchoolStaff), // Hidden for school staff
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