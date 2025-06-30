<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends AbstractModel
{
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
