<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku'        => 'SKU' . $this->faker->unique()->randomNumber(3, true),
            'price'      => $this->faker->randomFloat(2),
            'created_at' => now()
        ];
    }
}
