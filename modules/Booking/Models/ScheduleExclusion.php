<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Database\Factories\ScheduleExclusionFactory;

final class ScheduleExclusion extends Model
{
    use HasFactory;

    protected $table = 'modules_schedule_exclusions';

    protected $fillable = [
        'employee_id',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function newFactory(): ScheduleExclusionFactory
    {
        return ScheduleExclusionFactory::new();
    }
}
