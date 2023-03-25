<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'rua' => fake()->streetAddress(),
            'cidade' => fake()->city(),
            'estado' => fake()->state(),
            'cep' => fake()->postcode(),
            'user_id' => User::all()->random()->id
        ];
    }
}
