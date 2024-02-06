<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Booking\Database\Factories\EmployeeFactory;
use Rennokki\QueryCache\Traits\QueryCacheable;

final class Employee extends Model
{
    use HasFactory, QueryCacheable;

    protected $table = 'modules_employees';

    protected $fillable = ['name', 'profile_picture_url'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'modules_employee_service');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function scheduleExclusion(): HasMany
    {
        return $this->hasMany(ScheduleExclusion::class);
    }

    protected static function newFactory(): EmployeeFactory
    {
        return EmployeeFactory::new();
    }
}
