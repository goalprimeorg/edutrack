<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends AbstractAuthenticatableModel implements FilamentUser
{

    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'area_of_lga' => 'array',
            'services' => 'array',
        ]);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function lga()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'lga_id');
    }

    public function shipment(): HasMany
    {
        return $this->hasMany(Inventory::class, 'partner_id');
    }
}
