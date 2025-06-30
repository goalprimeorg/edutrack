<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\SchoolResource\Pages;
use App\Filament\SuperAdmin\Resources\SchoolResource\Pages\SortStudent;
use App\Models\LocalGovernmentArea;
use App\Models\School;
use CodeWithDennis\SimpleMap\Components\Forms\SimpleMap;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'School';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
//                Forms\Components\TextInput::make('address')
//                    ->required()
//                    ->maxLength(255),
                Forms\Components\Select::make('state_id')
                ->label(__('State'))
                ->relationship('state', 'name')
                ->options(\App\Models\State::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('local_government_area_id', null);
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
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255)
                    ->suffixAction(
                        SimpleMap::make('address')
                            ->icon('heroicon-o-map')
                            ->address('Maiduguri, Borno, NG')
                            ->center('37.4218,-122.0840')
                            ->zoom(10)
                            ->satellite()
                            ->language('en')
                            ->region('NG'),
                    ),
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
            'staffIndex' => Pages\SchoolTeacher::route('/{record}/staff'),
            'studentIndex' => Pages\SchoolStudent::route('/{record}/student'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}
