<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Contracts\IVoucherService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoucherServiceTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_create_voucher(): void
    {
        $user = User::factory()->create();

        $items = [
            [
                'quantity' => $this->faker->numberBetween(1, 100),
                'description' => $this->faker->randomElement(['Gasolina', 'Diesel', 'Otros']),
                'unit_price' => $this->faker->randomFloat(2, 1, 5),
                'total_price' => $this->faker->randomFloat(2, 50, 200),
            ],
        ];

        $voucherData = [
            'date' => $this->faker->date(),
            'delivery_to' => $this->faker->name,
            'vehicle' => $this->faker->text,
            'plate' => $this->faker->randomNumber(nbDigits: 3)  . (strtoupper($this->faker->randomLetter(3))),
            'kilometer' => strval($this->faker->randomNumber(nbDigits: 5)),
            'station_name' => $this->faker->company,
            'total_amount' => collect($items)->sum('total_price'),
            'items' => $items
        ];

        $voucherService = app(IVoucherService::class);

        $voucher = $voucherService->createVoucher($user, $voucherData);

        $this->assertDatabaseHas('vouchers', [
            'id' => $voucher->id
        ]);

        foreach($items as $item) {
            $this->assertDatabaseHas('voucher_items', [
                'voucher_id' => $voucher->id,
                'description' => $item['description']
            ]);
        }
    }
}
