<?php

namespace Modules\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Schedule;

final class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;
    public function definition(): array
    {
        $startTimes = ['08:00:00', '09:00:00', '10:00:00', '11:00:00'];
        $endTimes = ['17:00:00', '18:00:00', '19:00:00', '20:00:00'];
        return [
            'employee_id' => Employee::factory(),
            'starts_at' => $starts = now()->format('Y-m-d'),
            'ends_at' => $this->faker->dateTimeBetween($starts, '+1 year'),
            'monday_starts_at' => $this->faker->randomElement($startTimes),
            'monday_ends_at' => $this->faker->randomElement($endTimes),
            'tuesday_starts_at' => $this->faker->randomElement($startTimes),
            'tuesday_ends_at' => $this->faker->randomElement($endTimes),
            'wednesday_starts_at' => $this->faker->randomElement($startTimes),
            'wednesday_ends_at' => $this->faker->randomElement($endTimes),
            'thursday_starts_at' => $this->faker->randomElement($startTimes),
            'thursday_ends_at' => $this->faker->randomElement($endTimes),
            'friday_starts_at' => $this->faker->randomElement($startTimes),
            'friday_ends_at' => $this->faker->randomElement($endTimes),
            'saturday_starts_at' => $this->faker->randomElement($startTimes),
            'saturday_ends_at' => $this->faker->randomElement($endTimes),
            'sunday_starts_at' => $this->faker->randomElement($startTimes),
            'sunday_ends_at' => $this->faker->randomElement($endTimes),
        ];
    }
}