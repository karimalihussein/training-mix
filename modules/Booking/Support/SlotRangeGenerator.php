<?php

namespace Modules\Booking\Support;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

final class SlotRangeGenerator
{
    public function __construct(protected Carbon $start, protected Carbon $end, protected int $interval)
    {
    }

    public function generate(): \Illuminate\Support\Collection
    {
        $collection = collect();

        $days = CarbonPeriod::create(
            $this->start,
            '1 day',
            $this->end
        );

        foreach ($days as $day) {
            $date = new Date($day);
            $times = CarbonPeriod::create(
                $day->startOfDay(),
                $this->interval . ' minutes',
                $day->copy()->endOfDay()
            );

            foreach ($times as $time) {
                $date->addSlot(new Slot($time));
            }

            $collection->push($date);
        }

        return $collection;
    }
}
