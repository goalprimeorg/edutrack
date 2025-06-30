<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SchoolMetric extends AbstractModel
{
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
