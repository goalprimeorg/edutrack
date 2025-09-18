<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudentDistribution extends Model
{
    protected $fillable = ['student_id','staff_id','group_item_id','distributed_by','distributed_at','remark'];
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        }
    });
}

public $incrementing = false;
protected $keyType = 'string';

    public function group()
    {
        return $this->belongsTo(GroupItem::class, 'group_item_id');
    }

    public function items()
    {
        return $this->hasMany(StudentDistributionItem::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
