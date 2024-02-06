<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booking\Database\Factories\CustomerFactory;

final class Customer extends Model
{
    use HasFactory;

    protected $table = 'modules_customers';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }
}
