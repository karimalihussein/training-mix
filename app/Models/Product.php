<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @return array
     */
    protected $fillable = [
        'name',
        'type',
        'price',
    ];

    public function getPriceInUsdAttribute()
    {
        return number_format($this->price / 100, 2);
    }
}
