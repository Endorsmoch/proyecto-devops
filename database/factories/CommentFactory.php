<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idProduct' => $faker->randomDigit(),
            'idUser' => $faker->randomDigit(),
            'text' => $faker->text(),
            'likes' => $faker->randomDigit()
        ];
    }
}
