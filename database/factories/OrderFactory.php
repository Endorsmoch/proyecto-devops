<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUser' => $this->faker->randomNumber(),
            'idProduct' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomNumber(),
            'paymentMethod' => $this->faker->sentence()
        ];
    }
}
