<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const APPROVAL_PENDING = 1;

    public const APPROVAL_APPROVED = 2;

    protected $fillable = [
        'title',
        'description',
        'lat',
        'lng',
        'approval_status',
        'hidden',
        'price_per_day',
        'monthly_discount',
        'user_id',
        'address_line1',
        'address_line2',
        'featured_image_id',

    ];

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'approval_status' => 'integer',
        'hidden' => 'bool',
        'price_per_day' => 'integer',
        'monthly_discount' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'resource');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', self::APPROVAL_APPROVED);
    }

    public function scopeNotHidden($query)
    {
        return $query->where('hidden', false);
    }

    public function scopeNearestTo(Builder $builder, $lat, $lon)
    {
        return $builder
            ->selectRaw("*, ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance")
            ->having('distance', '<', 10)
            ->orderBy('distance');

        // return $builder->near($lat, $lon)
        //     ->orderBy('distance');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'offices_tags');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'featured_image_id');
    }
}
