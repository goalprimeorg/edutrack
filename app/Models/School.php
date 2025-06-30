<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class School extends AbstractModel
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'state_id',
        'local_government_area_id',
        'ward',
        'community',
        'address',
        'latitude',
        'longitude',
        'has_completed_profile',
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
    public function referral(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function staff()
    {
        return $this->hasMany(SchoolStaff::class, 'school_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class, 'school_id');
    }

    public function classroom()
    {
        return $this->hasMany(Classroom::class, 'school_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id');
    }

    public function schoolAdmin()
    {
        return $this->hasOne(SchoolStaff::class, 'school_id')->where('role', 'admin');
    }

    public function metric()
    {
        return $this->hasOne(SchoolMetric::class, 'school_id');
    }

    public function request()
    {
        return $this->hasMany(Request::class, 'school_id');
    }
}
