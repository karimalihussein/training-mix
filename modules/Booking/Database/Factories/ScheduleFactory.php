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
        return [
            'employee_id' => Employee::factory(),
            'starts_at' => $starts = now()->format('Y-m-d'),
            'ends_at' => $this->faker->dateTimeBetween($starts, '+1 year'),
            'monday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'monday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
            'tuesday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'tuesday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
            'wednesday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'wednesday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
            'thursday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'thursday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
            'friday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'friday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
            'saturday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'saturday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
            'sunday_starts_at' => $this->faker->randomElement(['08:00:00', '09:00:00', '10:00:00', '11:00:00']),
            'sunday_ends_at' => $this->faker->randomElement(['17:00:00', '18:00:00', '19:00:00', '20:00:00']),
        ];
    }
}