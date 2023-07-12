<?php

declare(strict_types=1);

namespace App\Services\Subscriptions;
use Bpuig\Subby\Models\Plan;
use Bpuig\Subby\Models\PlanCombination;
use Bpuig\Subby\Services\Period;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SubscriptionPeriod extends \Bpuig\Subby\Services\SubscriptionPeriod
{
    protected $trialEnd = null;
    protected $start = null;
    protected $end = null;

    protected $plan;
    protected $startDate;

    /**
     * @throws Exception
     */
    public function __construct(Plan|PlanCombination $plan, Carbon $startDate)
    {
         parent::__construct($plan, $startDate);
        $this->plan = $plan;
        $this->startDate = $startDate;
        $this->setSubscriptionPeriod();
    }

    /**
     * @throws Exception
     */
    private function setSubscriptionPeriod(): void
    {
        $period = new Period($this->plan->invoice_interval, $this->plan->invoice_period, $this->startDate);
        $this->start = $period->getStartDate();
        $this->end = $period->getEndDate();
    }
}
