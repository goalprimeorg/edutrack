<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Student extends AbstractModel
{
    use SoftDeletes;
    protected $fillable = [
        'school_id',
        'current_classroom_id',
        'first_name',
        'middle_name',
        'last_name',
        'state_id',
        'local_government_area_id',
        'gender',
        'is_student_disabled',
        'disability',
        'registration_number',
        'guardian_first_name',
        'guardian_last_name',
        'guardian_phone_number',
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

            if (empty($model->registration_number)) {
                $model->registration_number = static::generateRegistrationNumber();
            }
        });
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /* Generate a unique registration number (e.g., STU-2025-123456).
    *
    * @return string
    */
   protected static function generateRegistrationNumber(): string
   {
       $year = now()->format('Y');
       $random = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT); // 6-digit random number
       $registrationNumber = "STU-{$year}-{$random}";

       // Ensure uniqueness
       while (static::where('registration_number', $registrationNumber)->exists()) {
           $random = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
           $registrationNumber = "STU-{$year}-{$random}";
       }

       return $registrationNumber;
   }

    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id', 'id');
    }
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function currentClassroom()
    {
        return $this->belongsTo(Classroom::class, 'current_classroom_id');
    }

    public function referral(): HasMany
    {
        return $this->hasMany(Referral::class, 'referral_id');
    }
}
