<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booking\Database\Factories\ServiceFactory;

final class Service extends Model
{
    use HasFactory;

    protected $table = 'modules_services';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'modules_employee_service');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    protected static function newFactory(): ServiceFactory
    {
        return ServiceFactory::new();
    }
}
