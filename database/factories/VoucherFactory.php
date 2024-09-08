<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'delivery_to' => $this->faker->name,
            'vehicle' => $this->faker->text,
            'plate' => $this->faker->randomNumber(nbDigits: 3)  . (strtoupper($this->faker->randomLetter(3))),
            'kilometer' => strval($this->faker->randomNumber(nbDigits: 5)),
            'station_name' => $this->faker->company,
            'total_amount' => $this->faker->randomNumber(nbDigits: 3)
        ];
    }
}
