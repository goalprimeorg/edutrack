<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LocalGovernmentArea extends AbstractModel
{
    protected $fillable = ['name', 'state_id'];

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
    

    public function school(): HasMany
    {
        return $this->hasMany(School::class);
    }

    public function emis(): HasMany
    {
        return $this->hasMany(Emis::class);
    }

    public function partner(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function emisHead(): HasMany
    {
        return $this->hasMany(EmisHead::class);
    }
}
