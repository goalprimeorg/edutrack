<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends AbstractModel
{
    protected $guarded = [];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function referralServiceType(): BelongsTo
    {
        return $this->belongsTo(ReferralServiceType::class, 'referral_service_type_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
