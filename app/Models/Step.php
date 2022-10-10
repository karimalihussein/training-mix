<?php

namespace App\Models;

use App\Ordering\Traits\HasOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory, HasOrder;

    protected $fillable = [
        'title',
        'order'
    ];

    public function visits()
    {
        return $this->morphMany(Visit::class, 'visitable');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($step) {
  
            if (is_null($step->order)) {
                $step->order = self::max('order') + 1;
            }
        });
    }

  
}
