<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Database\Factories\OrderFactory;

final class Order extends Model
{
    use HasFactory;
    protected $table = 'modules_orders';
    protected $fillable = [
        'user_id',
        'status',
        'total_in_cents',
        'payment_gateway',
        'payment_id',
    ];

    protected $casts = [
        'total_in_cents' => 'integer',
        'user_id' => 'integer',
    ];

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}