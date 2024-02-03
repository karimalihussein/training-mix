<?php

namespace Modules\Booking\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Database\Factories\ScheduleFactory;

final class Schedule extends Model
{
    use HasFactory;

    protected $table = 'modules_schedules';

    protected $fillable = [
        'employee_id',
        'starts_at',
        'ends_at',
        'monday_starts_at',
        'monday_ends_at',
        'tuesday_starts_at',
        'tuesday_ends_at',
        'wednesday_starts_at',
        'wednesday_ends_at',
        'thursday_starts_at',
        'thursday_ends_at',
        'friday_starts_at',
        'friday_ends_at',
        'saturday_starts_at',
        'saturday_ends_at',
        'sunday_starts_at',
        'sunday_ends_at',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function newFactory(): ScheduleFactory
    {
        return ScheduleFactory::new();
    }

    public function workingHoursFromDate(Carbon $date): array
    {
        $day = strtolower($date->format('l'));

        $hours = array_filter([
            $this->{"{$day}_starts_at"},
            $this->{"{$day}_ends_at"},
        ]);

        return empty($hours) ? null : $hours;
    }
}
