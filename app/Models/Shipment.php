<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends AbstractModel
{
    public function partnerFrom(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_from_id');
    }

    public function partnerTo(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_to_id');
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
