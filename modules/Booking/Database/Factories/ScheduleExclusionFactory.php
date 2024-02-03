<?php

namespace Modules\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\ScheduleExclusion;

final class ScheduleExclusionFactory extends Factory
{
    protected $model = ScheduleExclusion::class;
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'starts_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'ends_at' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}