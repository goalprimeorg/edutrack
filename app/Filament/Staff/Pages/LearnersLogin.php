<?php

namespace App\Filament\SuperAdmin\Pages;

use Filament\Pages\Auth\Login as BaseLogin;

class LearnersLogin extends BaseLogin
{
    /**
     * Browser page <title>
     */
    public function getTitle(): string
    {
        return 'Formal Learners Login';
    }

    /**
     * Heading above the login form
     */
    public function getHeading(): string
    {
        return 'Formal Learners Portal';
    }

    /**
     * Subheading below the heading
     */
    public function getSubheading(): ?string
    {
        return 'Sign in to continue to your dashboard.';
    }

    /**
     * Custom Blade view for login
     */
    protected static string $view = 'filament.pages.auth.login';
}
