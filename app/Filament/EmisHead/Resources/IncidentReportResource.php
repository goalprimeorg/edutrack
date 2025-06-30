<?php

namespace App\Filament\EmisHead\Resources;

use App\Filament\EmisHead\Resources\IncidentReportResource\Pages;
use App\Models\IncidentReport;
use App\Models\IncidentType;
use App\Models\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IncidentReportResource extends Resource
{
    protected static ?string $model = IncidentReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?string $navigationGroup = 'Incident';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->label('School')
                    ->searchable()
                    ->options(School::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('incident_type_id')
                    ->label('Incident Type')
                    ->options(IncidentType::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name_of_reporter')
                    ->required(),
                Forms\Components\TextInput::make('tracking_code')
                    ->required(),
                Forms\Components\DatePicker::make('date_of_incident')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('incidentType.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_incident')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_of_reporter')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracking_code')
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListIncidentReports::route('/'),
            'create' => Pages\CreateIncidentReport::route('/create'),
            'view' => Pages\ViewIncidentReport::route('/{record}'),
            'edit' => Pages\EditIncidentReport::route('/{record}/edit'),
        ];
    }
}
