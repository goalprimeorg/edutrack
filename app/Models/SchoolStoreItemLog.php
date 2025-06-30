<?php

namespace App\Models;

class SchoolStoreItemLog extends AbstractModel
{
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function schoolStoreItem()
    {
        return $this->belongsTo(SchoolStoreItem::class, 'school_store_item_id');
    }

    public function schoolStaff()
    {
        return $this->belongsTo(SchoolStaff::class, 'school_staff_id');
    }
}
