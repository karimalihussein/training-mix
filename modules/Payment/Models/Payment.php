<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Payment extends Model
{
    use HasFactory;

    protected $table = 'modules_payments';
    protected $fillable = [
        'order_id',
        'status',
        'provider',
        'provider_payment_id',
    ];
}
