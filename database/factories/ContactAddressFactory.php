<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactAddress>
 */
class ContactAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_id' => $this->faker->numberBetween(1, 500),
            'street' => $this->faker->streetName(),
            'between_streets' => $this->faker->streetName(),
            'zip' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'num_ext' => $this->faker->numberBetween(1, 100),
            'num_int' => $this->faker->numberBetween(1, 100),
        ];
    }
}
