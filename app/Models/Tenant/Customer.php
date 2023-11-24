<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'customer_at',
        'tenant_id',
        'company_code',
        'user_id',
        'contract_at',
        'active'
    ];

    protected $casts = [
        'customer_at' => 'datetime',
        'tenant_id' => 'string',
        'company_code' => 'integer',
        'contract_at' => 'datetime',
        'active' => 'boolean',
    ];

    protected $dates = [
        'customer_at',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function format()
    {
        return [
            'customer_id' => $this->id,
            'name' => $this->name,
            'created_by' => $this->user->name,
            'active' => $this->active,
            'company_code' => $this->company_code,
            'customer_at' => $this->customer_at->format('Y-m-d'),
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'last_updated' => $this->updated_at->diffForHumans(),
        ];
    }

    public static function booted()
    {
        static::creating(function ($customer) {
            $customer->company_code = $customer->company_code ?? rand(999, 9999);
        });
    }
}
