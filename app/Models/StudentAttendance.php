<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StudentAttendance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'student_attendance_meta_id',
        'attendance_status',
        'state_id',
        'local_government_area_id',
    ];
    protected $casts = [
        'attendance_status' => 'string',
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

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function attendanceMeta()
    {
        return $this->belongsTo(StudentAttendanceMeta::class, 'student_attendance_meta_id', 'id');
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
