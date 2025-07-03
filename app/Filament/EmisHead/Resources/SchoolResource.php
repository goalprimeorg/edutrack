<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\SchoolResource\Pages;
use App\Models\LocalGovernmentArea;
use App\Models\School;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
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
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('school_admin_first_name')
                    ->label(__('School Contact Person First Name'))
                    ->visibleOn('create')
                    ->required(),
                Forms\Components\TextInput::make('school_admin_middle_name')
                    ->label(__('School Contact Person Middle Name'))
                    ->visibleOn('create')
                    ->nullable(),
                Forms\Components\TextInput::make('school_admin_last_name')
                    ->label(__('School Contact Person Last Name'))
                    ->visibleOn('create')
                    ->required(),
                Forms\Components\TextInput::make('school_admin_email')
                    ->unique('school_staff', 'email', ignoreRecord: true)
                    ->visibleOn('create')
                    ->email()
                    ->label(__('School Contact Person Email'))
                    ->required(),
                Forms\Components\TextInput::make('school_admin_phone')
                    ->label(__('School Contact Person Phone'))
                    ->visibleOn('create')
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
                    $query->where('state_id', $user->state_id); 
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('School Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->label(__('State'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')
                    ->label('Local Government Area')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('school_admin_email')
                    ->label('Contact Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('school_admin_phone')
                    ->label('Contact Phone')
                    ->searchable(),
            ])
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
                    ->label('Local Government Area')
                    ->relationship('localGovernmentArea', 'name')
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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'view' => Pages\ViewSchool::route('/{record}/view'),
            'teacher' => Pages\ViewTeacherTable::route('/{record}/teacher'),
            'student' => Pages\ListStudentTable::route('/{record}/student'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}