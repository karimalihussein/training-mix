<?php

namespace Modules\Booking\Support;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Schedule;
use Modules\Booking\Models\ScheduleExclusion;
use Modules\Booking\Models\Service;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;

final class ScheduleAvailability
{
    private PeriodCollection $periods;
    private Employee $employee;
    private Service $service;

    public function __construct(Employee $employee, Service $service)
    {
        $this->employee = $employee;
        $this->service = $service;
        $this->periods = new PeriodCollection();
    }

    public function forPeriod(Carbon $startAt, Carbon $endAt): PeriodCollection
    {
        collect(CarbonPeriod::create($startAt, $endAt)->days())->each(function (Carbon $date) {
            $this->addAvailabilityFromSchedule($date);
            $this->subtractScheduleExclusions($date);
            $this->excludeTimePassedToday();
        });

        return $this->periods;
    }

    private function addAvailabilityFromSchedule(Carbon $date): void
    {
        $schedule = $this->getScheduleForDate($date);

        if (!$schedule || ![$start, $end] = $schedule->workingHoursFromDate($date)) {
            return;
        }

        $this->periods = $this->periods->add(
            Period::make(
                $date->copy()->setTimeFromTimeString($start),
                $date->copy()->setTimeFromTimeString($end)->subMinutes($this->service->duration),
                Precision::MINUTE()
            )
        );
    }

    private function subtractScheduleExclusions(Carbon $date): void
    {
        $this->employee->exclusions()->each(function (ScheduleExclusion $exclusion) use ($date) {
            $this->periods = $this->periods->subtract(
                Period::make(
                    $date->copy()->setTimeFromTimeString($exclusion->starts_at),
                    $date->copy()->setTimeFromTimeString($exclusion->ends_at),
                    Precision::MINUTE(),
                    Boundaries::EXCLUDE_END()
                )
            );
        });
    }

    private function excludeTimePassedToday(): void
    {
        if ($this->periods->isEmpty()) {
            return;
        }

        $now = Carbon::now();
        $this->periods = $this->periods->subtract(
            Period::make(
                Carbon::today(),
                $now,
                Precision::MINUTE(),
                Boundaries::EXCLUDE_START()
            )
        );
    }

    private function getScheduleForDate(Carbon $date): ?Schedule
    {
        return $this->employee->schedules()
            ->where('starts_at', '<=', $date)
            ->where('ends_at', '>=', $date)
            ->first();
    }
}
