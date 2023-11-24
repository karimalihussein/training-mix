<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 1;

    public const STATUS_CANCELLED = 2;

    protected $fillable = [
        'user_id',
        'office_id',
        'status',
        'start_date',
        'end_date',
        'wifi_password',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
        'status' => 'integer',
        'start_date' => 'immutable_date',
        'end_date' => 'immutable_date',
        'wifi_password' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function scopeBetweenDates($query, $start, $end)
    {
        $query->where(function ($query) use ($start, $end) {
            $query->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end])
                ->orWhere(function ($query) use ($start, $end) {
                    $query->where('start_date', '<', $start)
                        ->where('end_date', '>', $end);
                });
        });
    }

    public function scopeActiveBetween($query, $start, $end)
    {
        $query->whereStatus(self::STATUS_ACTIVE)
            ->betweenDates($start, $end);
    }
}
