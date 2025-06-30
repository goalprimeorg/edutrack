<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Emis extends AbstractAuthenticatableModel implements FilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'state_id',
        'local_government_area_id',
    
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    
    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id');
    }
}
