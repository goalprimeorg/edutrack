<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends AbstractModel
{
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
