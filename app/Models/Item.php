<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends AbstractModel
{
    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id');
    }
}
