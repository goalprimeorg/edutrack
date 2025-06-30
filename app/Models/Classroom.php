<?php

namespace App\Models;

class Classroom extends AbstractModel
{
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
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class, 'current_classroom_id');
    }

    public function formTeacher()
    {
        return $this->belongsTo(SchoolStaff::class, 'form_teacher_id');
    }
}
