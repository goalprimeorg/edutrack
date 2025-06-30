<?php

namespace App\Filament\SuperAdmin\Resources\SchoolResource\Pages;

use App\Filament\SuperAdmin\Resources\SchoolResource;
use App\Models\SchoolStaff;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolTeacher extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected static ?string $breadcrumb = 'Teachers';

    protected static ?string $title = 'Teachers';

    public $record;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('New School Staff')
                ->url('/superAdmin/school-staffs/create'),
        ];
    }

    public function table(Table $table): Table
    {

        return $table->columns([
            TextColumn::make('first_name'),
            TextColumn::make('middle_name'),
            TextColumn::make('last_name'),
            TextColumn::make('phone_number'),
        ])
            ->actions([
                Action::make('view')
                    ->url(fn (SchoolStaff $teacher): string => "/superAdmin/school-staffs/{$teacher->id}/view"),
            ])
            ->emptyStateHeading('No Teachers')
            ->query(function () {
                return SchoolStaff::where([
                    'school_id' => $this->record,
                ]);
            });
    }
}
