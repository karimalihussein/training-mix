<?php

namespace Modules\Booking\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final class Date
{
    public Collection $slots;
    public function __construct(public Carbon $date)
    {
        $this->slots = collect();
    }

    public function addSlot(Slot $slot)
    {
        $this->slots->push($slot);
    }
}
