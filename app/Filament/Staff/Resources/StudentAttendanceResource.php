<?php

namespace App\Filament\Staff\Resources;

use App\Filament\SuperAdmin\Resources\StudentAttendanceResource\Pages;
use App\Filament\SuperAdmin\Resources\StudentAttendanceResource\RelationManagers;
use App\Filament\Exports\StudentAttendanceExportExporter;
use App\Models\StudentAttendanceMeta;
use App\Models\StudentAttendance;
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

class StudentAttendanceResource extends Resource
{
    protected static ?string $model = StudentAttendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'School';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();
        $isSchoolStaff = !$isSuperAdmin && $user->school_id; // Assuming school staff have school_id

        $stateOptions = $isSuperAdmin 
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id'); // Assuming user has state_id

        return $form
            ->schema([
                Forms\Components\Select::make('student_attendance_meta_id')
                    ->label(__('Attendance Meta'))
                    ->options(function () use ($user, $isSuperAdmin, $isSchoolStaff) {
                        $query = StudentAttendanceMeta::with(['school', 'classroom']);
                        if ($isSchoolStaff) {
                            $query->where('school_id', $user->school_id);
                            if ($user->class_id) {
                                $query->where('classroom_id', $user->class_id);
                            }
                        } elseif (!$isSuperAdmin) {
                            $query->whereHas('school', fn ($q) => $q->where('state_id', $user->state_id));
                        }
                        return $query->get()
                            ->mapWithKeys(function ($meta) {
                                return [$meta->id => "{$meta->school->name} - {$meta->classroom->name} - {$meta->date_of_attendance}"];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->disabled($isSchoolStaff && $user->class_id), // Fixed for staff with class_id
                Forms\Components\Checkbox::make('select_all_students')
                    ->label(__('Select All Students in Classroom'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('student_id', null);
                        }
                    })
                    ->disabled($isSchoolStaff && !$user->class_id), // Disabled if no class_id
                Forms\Components\Select::make('student_id')
                    ->label(__('Student'))
                    ->options(function (?string $state, Forms\Get $get) use ($user, $isSchoolStaff) {
                        $metaId = $get('student_attendance_meta_id');
                        if (!$metaId) {
                            return [];
                        }

                        $meta = StudentAttendanceMeta::find($metaId);
                        if (!$meta) {
                            return [];
                        }

                        $query = Student::where('current_classroom_id', $meta->classroom_id);
                        if ($isSchoolStaff && $user->class_id) {
                            $query->where('current_classroom_id', $user->class_id);
                        }

                        $existingStudentIds = StudentAttendance::where('student_attendance_meta_id', $metaId)
                            ->pluck('student_id')
                            ->toArray();

                        return $query->whereNotIn('id', $existingStudentIds)
                            ->get()
                            ->mapWithKeys(function ($student) {
                                return [$student->id => "{$student->first_name} - {$student->last_name}"];
                            });
                    })
                    ->searchable()
                    ->required(fn (Forms\Get $get) => !$get('select_all_students'))
                    ->disabled(fn (Forms\Get $get) => $get('select_all_students'))
                    ->dehydrated(fn (Forms\Get $get) => !$get('select_all_students')),
                Forms\Components\Select::make('attendance_status')
                    ->label(__('Attendance Status'))
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'late' => 'Late',
                        'sick' => 'Sick',
                    ])
                    ->required()
                    ->default('present'),
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
                    ->visible(!$isSchoolStaff), // Hidden for school staff
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();
        $isSchoolStaff = !$isSuperAdmin && $user->school_id; // Assuming school staff have school_id

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user, $isSuperAdmin, $isSchoolStaff) {
                $query->with(['attendanceMeta.school', 'attendanceMeta.classroom', 'student']);
                if ($isSchoolStaff) {
                    $query->whereHas('attendanceMeta', fn ($q) => $q->where('school_id', $user->school_id));
                    if ($user->class_id) {
                        $query->whereHas('attendanceMeta', fn ($q) => $q->where('classroom_id', $user->class_id));
                    }
                } elseif (!$isSuperAdmin) {
                    $query->whereHas('attendanceMeta.school', fn ($q) => $q->where('state_id', $user->state_id));
                }
                $query->join('student_attendance_metas', 'student_attendance_metas.id', '=', 'student_attendances.student_attendance_meta_id')
                      ->orderBy('student_attendance_metas.date_of_attendance', 'desc')
                      ->select('student_attendances.*');
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('attendanceMeta.school.name')
                    ->label(__('School'))
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('student.first_name')
                    ->label(__('First Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.last_name')
                    ->label(__('Last Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('attendanceMeta.classroom.name')
                    ->label(__('Classroom'))
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('attendanceMeta.date_of_attendance')
                    ->label(__('Date'))
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\SelectColumn::make('attendance_status')
                    ->label(__('Status'))
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'late' => 'Late',
                        'sick' => 'Sick',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->label(__('Local Government Area'))
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school_id')
                    ->label(__('School'))
                    ->relationship('attendanceMeta.school', 'name')
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
                Tables\Filters\SelectFilter::make('student_attendance_meta_id')
                    ->label(__('Attendance Meta'))
                    ->options(function () use ($user, $isSuperAdmin, $isSchoolStaff) {
                        $query = StudentAttendanceMeta::with(['classroom']);
                        if ($isSchoolStaff) {
                            $query->where('school_id', $user->school_id);
                            if ($user->class_id) {
                                $query->where('classroom_id', $user->class_id);
                            }
                        } elseif (!$isSuperAdmin) {
                            $query->whereHas('school', fn ($q) => $q->where('state_id', $user->state_id));
                        }
                        return $query->get()
                            ->mapWithKeys(function ($meta) {
                                return [$meta->id => "{$meta->classroom->name} - {$meta->date_of_attendance}"];
                            });
                    })
                    ->searchable()
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
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(StudentAttendanceExportExporter::class)
                    ->label('Export Filtered Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()
                        ->exporter(StudentAttendanceExportExporter::class),
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
            'index' => Pages\ListStudentAttendances::route('/'),
            'create' => Pages\CreateStudentAttendance::route('/create'),
            'edit' => Pages\EditStudentAttendance::route('/{record}/edit'),
        ];
    }
}