<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuperAdmin extends AbstractAuthenticatableModel implements FilamentUser, HasName
{
    use HasFactory;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
