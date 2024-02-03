<?php

namespace Modules\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Booking\Models\Service;

final class ServiceFactory extends Factory
{
    protected $model = Service::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'duration' => $this->faker->randomElement([15, 30, 45, 60]),
            'price' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}