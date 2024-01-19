<?php

declare(strict_types=1);

namespace Modules\Order\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Models\Order;

final class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'total_in_cents' => $this->faker->numberBetween(1000, 10000),
            'payment_gateway' => $this->faker->randomElement(['stripe', 'paypal']),
        ];
    }
}
