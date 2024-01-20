<?php


namespace Modules\Product\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Product extends Model
{
    use HasFactory;

    protected $table = 'modules_products';

    protected $fillable = [
        'name',
        'price_in_cents',
        'description',
        'stock',
    ];

    protected $casts = [
        'price_in_cents' => 'integer',
        'stock' => 'integer',
    ];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
