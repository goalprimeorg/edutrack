<?php

namespace App\Filament\SuperAdmin\Pages;

use Filament\Panel;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.super-admin.pages.edit-profile';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->required()
                    ->maxLength(255),
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    public static function registerRoutes(Panel $panel): void
    {
        if (filled(static::getCluster())) {
            Route::name(static::prependClusterRouteBaseName(''))
                ->prefix(static::prependClusterSlug(''))
                ->group(fn () => static::routes($panel));

            return;
        }

        static::routes($panel);
    }
}
