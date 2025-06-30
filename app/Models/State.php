<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class State extends Model
{
    public function lgas()
    {
        return $this->hasMany(LocalGovernmentArea::class);
    }
    protected $fillable = ['name'];

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

    public function schools()
    {
        return $this->hasMany(School::class, 'state_id', 'id');
    }
}