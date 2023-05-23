<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'houseNum' => $this->faker->sentence(), 
            'street' => $this->faker->sentence(), 
            'city' => $this->faker->sentence(), 
            'state' => $this->faker->sentence(),
            'country' => $this->faker->sentence(),
            'postalCode' => $this->faker->sentence()
        ];
    }
}
