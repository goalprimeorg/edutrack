<?php

namespace App\Models;

class SchoolStaff extends AbstractAuthenticatableModel
{
    protected $casts = [
        'has_system_generated_password' => 'boolean',
        'is_staff_disabled' => 'boolean'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id', 'id');
    }

    public function currentClassroom()
    {
        return $this->hasOne(Classroom::class, 'form_teacher_id');
    }

    public function highestQualification()
    {
        return $this->belongsTo(QualificationType::class, 'highest_qualification_id');
    }
}
