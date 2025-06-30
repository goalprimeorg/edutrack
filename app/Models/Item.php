<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends AbstractModel
{
    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
