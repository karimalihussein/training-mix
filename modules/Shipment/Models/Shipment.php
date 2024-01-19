<?php

namespace Modules\Shipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Shipment extends Model
{
    use HasFactory;

    protected $table = 'modules_shipments';
    protected $fillable = [
        'order_id',
        'status',
        'provider',
        'provider_shipment_id',
    ];
}
