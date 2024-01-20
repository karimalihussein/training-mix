<?php

declare(strict_types=1);

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

final class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price_in_cents' => $this->faker->numberBetween(1000, 10000),
            'description' => $this->faker->text,
        ];
    }
}
