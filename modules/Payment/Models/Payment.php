<?php

namespace Modules\Payment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentProvider;

final class Payment extends Model
{
    use HasFactory;
    protected $table = 'modules_payments';
    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'payment_gateway',
        'payment_id',
    ];

    protected $casts = [
        'payment_getway' => PaymentProvider::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}