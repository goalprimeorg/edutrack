<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\ReferralResource\Pages;
use App\Models\Referral;
use App\Models\ReferralServiceType;
use App\Models\School;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Referral';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('created_by_id')
                    ->default(auth()->user()->id)
                    ->required(),
                Forms\Components\Select::make('school_id')
                    ->label('School')
                    ->options(School::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('student_id')
                    ->label('Student')
                    ->options(function (Forms\Get $get) {
                        $schoolId = $get('school_id');
                        if (! $schoolId) {
                            return;
                        }

                        return Student::where('school_id', $schoolId)->pluck('registration_number', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('referral_service_type_id')
                    ->options(ReferralServiceType::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('remarks')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.registration_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('referralServiceType.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListReferrals::route('/'),
            'create' => Pages\CreateReferral::route('/create'),
            'edit' => Pages\EditReferral::route('/{record}/edit'),
        ];
    }
}
