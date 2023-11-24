<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'invoice_date', 'customer_name', 'order_id'];

    protected $dates = ['invoice_date'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'price']);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($invoice) {
            // Uncomment this line if you wish to use it instead of the service
            $invoice->invoice_number = self::max('invoice_number') + 1;
        });
    }
}
