<?php

namespace App\Filament\SuperAdmin\Resources;

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
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationItem;

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
            : State::where('id', $user->state_id)->pluck('name', 'id'); // Assuming user has state_id

        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label(__('School'))
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (!$isSuperAdmin) {
                            return School::where('state_id', $user->state_id)->pluck('name', 'id');
                        }
                        return School::pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
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
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required(),
                Forms\Components\TextInput::make('middle_name')
                    ->nullable(),
                Forms\Components\TextInput::make('last_name')
                    ->required(),
                Forms\Components\Select::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options($stateOptions)
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('local_government_area_id', null); // Reset LGA
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
                Forms\Components\Select::make('gender')
                    ->options(['Male' => 'Male', 'Female' => 'Female'])
                    ->required(),
                Forms\Components\TextInput::make('registration_number')
                    ->nullable(),
                Forms\Components\TextInput::make('guardian_first_name')
                    ->required(),
                Forms\Components\TextInput::make('guardian_last_name')
                    ->required(),
                Forms\Components\TextInput::make('guardian_phone_number')
                    ->tel()
                    ->required(),
                    Forms\Components\Select::make('is_student_disabled')
                    ->label('Is Student Disabled?')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->native(false),
        
                Forms\Components\Select::make('disability')
                    ->label('Type of Disability')
                    ->options([
                        'Hearing' => 'Hearing',
                        'Cognitive' => 'Cognitive',
                        'Physical' => 'Physical',
                        'Hearing/Mutism' => 'Hearing/Mutism',
                        'Physical/Hearing' => 'Physical/Hearing',
                        'Physical/Hearing/Cognitive' => 'Physical/Hearing/Cognitive',
                        'Physical/Psychopathy' => 'Physical/Psychopathy',
                        'Psychopathy' => 'Psychopathy',
                        'Sickle Cell' => 'Sickle Cell',
                        'Visual' => 'Visual',
                        'N/A' => 'N/A',
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currentClassroom.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->label(__('Local Government Area'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('is_student_disabled')
                    ->label('Disabled?')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),
                
                Tables\Columns\TextColumn::make('disability')
                    ->label('Disability'),
                Tables\Columns\TextColumn::make('guardian_first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guardian_last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guardian_phone_number')
                    ->searchable(),
            ])
            ->modifyQueryUsing(function ($query) use ($user, $isSuperAdmin) {
                if (!$isSuperAdmin) {
                    $query->where('state_id', $user->state_id); // Restrict to user's state
                }
                return $query;
            })
            ->filters([
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
            'index' => \App\Filament\SuperAdmin\Resources\StudentResource\Pages\ListStudents::route('/'),
            'create' => \App\Filament\SuperAdmin\Resources\StudentResource\Pages\CreateStudent::route('/create'),
            'edit' => \App\Filament\SuperAdmin\Resources\StudentResource\Pages\EditStudent::route('/{record}/edit'),
            'view' => \App\Filament\SuperAdmin\Resources\StudentResource\Pages\ViewStudent::route('/{record}/view'),
        ];
    }
}