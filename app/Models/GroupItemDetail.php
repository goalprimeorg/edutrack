<?php
namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class GroupItemDetail extends Model
{
    protected $fillable = ['group_item_id','item_id','quantity'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    public function group()
    {
        return $this->belongsTo(GroupItem::class, 'group_item_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function groupItem()
{
    //return $this->belongsTo(GroupItem::class);
    return $this->belongsTo(GroupItem::class, 'group_item_id');
}
}
