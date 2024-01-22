<?php

namespace Modules\Order\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Order\Database\Factories\OrderFactory;
use Modules\Order\Exceptions\OrderMissingOrderLinesException;
use Modules\Payment\Models\Payment;
use Modules\Product\DTO\CartItemCollection;

final class Order extends Model
{
    public const PENDEING = 'pending';
    public const COMPLETED = 'completed';
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

    public static function startForUser(int $userId): self
    {
        return self::make([
            'user_id' => $userId,
            'status' => self::PENDEING,
            'payment_gateway' => 'paybuddy',
        ]);
    }

    /**
     * @param CartItemCollection $items
     * @return void
     */
    public function addLinesToOrder(CartItemCollection $items): void
    {
        foreach ($items->items() as $cartItem) {
            $this->lines->push(OrderLine::make([
                'product_id' => $cartItem->product->id,
                'quantity' => $cartItem->quantity,
                'price_in_cents' => $cartItem->product->priceInCents,
            ]));
        }
        $this->total_in_cents = $items->totalInCents();
    }

    public function fullfill(): void
    {
        if ($this->lines->isEmpty()) {
            throw new OrderMissingOrderLinesException("Can't fullfill an order without order lines.");
        }
        $this->status = self::COMPLETED;
        $this->save();
        $this->lines()->saveMany($this->lines);
    }

    public function localizedTotal(): string
    {
        return number_format($this->total_in_cents / 100, 2);
    }
}
