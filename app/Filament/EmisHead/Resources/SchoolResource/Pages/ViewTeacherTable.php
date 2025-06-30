<?php

namespace App\Filament\EmisHead\Resources\SchoolResource\Pages;

use App\Filament\EmisHead\Resources\SchoolResource;
use App\Models\School;
use App\Models\SchoolStaff;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Route;

class ViewTeacherTable extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected static ?string $breadcrumb = 'Teachers';

    protected static ?string $title = 'Teachers';

    public function table(Table $table): Table
    {
        $currentSchool = Route::current()->parameter('record');

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_login_date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school_id')
                    ->label(__('School'))
                    ->options(School::all()->pluck('name', 'id')),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn (SchoolStaff $teacher): string => "/emisHead/school-staffs/$teacher->id"),
            ])
            ->emptyStateHeading('No Teachers')
            ->query(function () use ($currentSchool) {
                return SchoolStaff::where([
                    'school_id' => $currentSchool,
                ]);
            });
    }
}
