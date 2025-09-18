<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends AbstractModel
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
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
