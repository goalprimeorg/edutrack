<?php

namespace App\Models;

class SchoolStoreItem extends AbstractModel
{
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function schoolStoreItemLogs()
    {
        return $this->hasMany(SchoolStoreItemLog::class, 'school_store_item_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function localGovernmentArea()
    {
        return $this->belongsTo(LocalGovernmentArea::class, 'local_government_area_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
