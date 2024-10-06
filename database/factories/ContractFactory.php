<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'station_name' => $this->faker->company,
            'station_nit' => $this->faker->randomNumber(8),
            'city' => $this->faker->city,
            'contract_number' => $this->faker->randomNumber(8),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 1, 5),
            'total_amount' => $this->faker->randomFloat(2, 50, 200)
        ];
    }
}
