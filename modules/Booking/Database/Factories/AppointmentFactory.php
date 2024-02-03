<?php

namespace Modules\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Booking\Enums\AppointmentStatusEnum;
use Modules\Booking\Models\Appointment;
use Modules\Booking\Models\Customer;
use Modules\Booking\Models\Service;

final class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'employee_id' => Service::factory(),
            'customer_id' => Customer::factory(),
            'start_at' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_at' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'status' => $this->faker->randomElement(AppointmentStatusEnum::cases()),
        ];
    }
}