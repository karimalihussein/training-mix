<?php

namespace Modules\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Booking\Models\Employee;
use Modules\Booking\Models\Schedule;
use Modules\Booking\Models\ScheduleExclusion;

final class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'profile_picture_url' => $this->faker->imageUrl(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Employee $employee) {
            Schedule::factory()->create([
                'employee_id' => $employee->id,
            ]);;
        });
    }
}