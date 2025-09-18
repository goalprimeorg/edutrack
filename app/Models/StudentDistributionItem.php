<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudentDistributionItem extends Model
{
    protected $fillable = ['student_distribution_id','item_id','quantity'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    public function distribution()
    {
        return $this->belongsTo(StudentDistribution::class, 'student_distribution_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
