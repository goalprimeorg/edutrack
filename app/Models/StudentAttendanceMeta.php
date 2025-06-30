<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StudentAttendanceMeta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'classroom_id',
        'marked_by_school_staff_id',
        'date_of_attendance',
        'state_id',
        'local_government_area_id',
    ];

    protected $casts = [
        'date_of_attendance' => 'date',
    ];

    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Use string for UUID

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function markedBy()
    {
        return $this->belongsTo(SchoolStaff::class, 'marked_by_school_staff_id', 'id'); 
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id', 'id');
    }
}
