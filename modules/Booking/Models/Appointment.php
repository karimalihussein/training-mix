<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Database\Factories\AppointmentFactory;
use Modules\Booking\Enums\AppointmentStatusEnum;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;

final class Appointment extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'modules_appointments';

    protected $fillable = [
        'service_id',
        'employee_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => AppointmentStatusEnum::class,
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function newFactory(): AppointmentFactory
    {
        return AppointmentFactory::new();
    }
}