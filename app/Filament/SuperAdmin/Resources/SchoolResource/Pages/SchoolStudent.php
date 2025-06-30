<?php

namespace App\Filament\SuperAdmin\Resources\SchoolResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolResource;
use App\Models\Student;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class SchoolStudent extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected static ?string $breadcrumb = 'Students';

    protected static ?string $title = 'Students';

    public $record;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('New School Student')
                ->url('/superAdmin/students/create'),
        ];
    }

    public function table(Table $table): Table
    {

        return $table->columns([
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
            Tables\Columns\TextColumn::make('registration_number')
                ->searchable(),
            Tables\Columns\TextColumn::make('guardian_first_name')
                ->searchable(),
            Tables\Columns\TextColumn::make('guardian_last_name')
                ->searchable(),
            Tables\Columns\TextColumn::make('guardian_phone_number')
                ->searchable(),
        ])
            ->actions([
                Action::make('view')
                    ->url(fn(Student $student): string => "/superAdmin/students/{$student->id}/view"),
            ])
            ->emptyStateHeading('No Teachers')
            ->query(function ()  {
                return Student::where([
                    'school_id' => $this->record,
                ]);
            });
    }
}
