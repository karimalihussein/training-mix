<?php

namespace Modules\Order\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Order\Database\Factories\OrderFactory;
use Modules\Payment\Models\Payment;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function lastPayment(): HasOne
    {
        return $this->payments()->one()->latest();
    }

    public function url(): string
    {
        return route('orders.show', $this);
    }
}