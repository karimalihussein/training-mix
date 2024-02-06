<?php

namespace Modules\Booking\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Service;

final class ServiceSlotAvailability
{
    public function __construct(
        protected Collection $employees,
        protected Service $service,
    ) {
    }

    public function forPeriod(Carbon $startAt, Carbon $endAt)
    {
        $range = (new SlotRangeGenerator($startAt, $endAt, $this->service->duration))->generate();

        $this->employees->each(function (Employee $employee) use ($range) {
        });
    }
}
