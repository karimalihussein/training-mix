<?php

namespace Modules\Booking\Support;

use Carbon\Carbon;

final class Slot
{
    public $employees = [];
    public function __construct(public Carbon $time)
    {
    }
}
