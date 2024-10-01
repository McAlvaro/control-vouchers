<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic unit test example.
     */
    public function test_index(): void
    {
        $user = User::factory()->create();
        $this->actingAs(user: $user);

        Voucher::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->get(route(name: 'vouchers.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn(Assert $page) => $page
            ->component('Vouchers/Index')
            ->has('vouchers.data', 2));
    }

    public function test_it_can_store_a_voucher()
    {

        $user = User::factory()->create();

        $items = [
            [
                'quantity' => $this->faker->numberBetween(1, 100),
                'description' => $this->faker->randomElement(['Gasolina', 'Diesel', 'Otros']),
                'unit_price' => number_format($this->faker->randomFloat(2, 1, 5), 2),
                'total_price' => number_format($this->faker->randomFloat(2, 50, 200), 2),
            ],
        ];

        Log::debug('Items: ' . json_encode($items));

        $token = csrf_token();

        $voucherData = [
            'date' => $this->faker->date(),
            'delivery_to' => $this->faker->name,
            'vehicle' => $this->faker->text,
            'plate' => $this->faker->randomNumber(nbDigits: 3)  . (strtoupper($this->faker->randomLetter(3))),
            'kilometer' => strval($this->faker->randomNumber(nbDigits: 5)),
            'station_name' => $this->faker->company,
            'total_amount' => number_format(collect($items)->sum('total_price'), 2),
            'items' => $items,
            '_token' => $token
        ];

        $response = $this->actingAs($user)->post(route(name: 'vouchers.store'), $voucherData);

        $response->assertRedirect(uri: route('vouchers.index'));

        $this->assertDatabaseHas('vouchers', [
            'delivery_to' => $voucherData['delivery_to'],
            'total_amount' => $voucherData['total_amount']
        ]);

        $this->assertDatabaseHas('voucher_items', [
            'description' => $items[0]['description'],
            'quantity' => $items[0]['quantity'],
            'unit_price' => $items[0]['unit_price']
        ]);
    }

    public function test_it_validates_store_request()
    {

        $user = User::factory()->create();

        $items = [
            [
                'quantity' => $this->faker->numberBetween(1, 100),
                'description' => $this->faker->randomElement(['Gasolina', 'Diesel', 'Otros']),
                'unit_price' => number_format($this->faker->randomFloat(2, 1, 5), 2),
                'total_price' => number_format($this->faker->randomFloat(2, 50, 200), 2),
            ],
        ];

        $token = csrf_token();

        $voucherData = [
            'date' => $this->faker->date(),
            'vehicle' => $this->faker->text,
            'plate' => $this->faker->randomNumber(nbDigits: 3)  . (strtoupper($this->faker->randomLetter(3))),
            'kilometer' => strval($this->faker->randomNumber(nbDigits: 5)),
            'station_name' => $this->faker->company,
            'total_amount' => number_format(collect($items)->sum('total_price'), 2),
            'items' => $items,
            '_token' => $token
        ];

        $response = $this->actingAs($user)->post(route(name: 'vouchers.store'), $voucherData);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['delivery_to']);
    }

    public function test_it_can_update_a_voucher()
    {

        $user = User::factory()->create();

        $token = csrf_token();

        $voucherData = [
            'date' => $this->faker->date(),
            'delivery_to' => $this->faker->firstName,
            'vehicle' => $this->faker->text,
            'plate' => $this->faker->randomNumber(nbDigits: 3)  . (strtoupper($this->faker->randomLetter(3))),
            'kilometer' => strval($this->faker->randomNumber(nbDigits: 5)),
            'station_name' => $this->faker->company,
            'total_amount' => number_format(30.56, 2),
            'user_id' => $user->id
        ];

        $voucher = Voucher::factory()->create($voucherData);

        $items = [
            [
                'quantity' => $this->faker->numberBetween(1, 100),
                'description' => $this->faker->randomElement(['Gasolina', 'Diesel', 'Otros']),
                'unit_price' => number_format($this->faker->randomFloat(2, 1, 5), 2),
                'total_price' => number_format($this->faker->randomFloat(2, 50, 200), 2),
                'voucher_id' => $voucher->id
            ]
        ];

        $voucherItems = VoucherItem::factory()->create($items[0]);

        $updatedData = [
            'date' => $this->faker->date(),
            'delivery_to' => 'Name updated',
            'vehicle' => $this->faker->text,
            'plate' => $this->faker->randomNumber(nbDigits: 3)  . (strtoupper($this->faker->randomLetter(3))),
            'kilometer' => strval($this->faker->randomNumber(nbDigits: 5)),
            'station_name' => $this->faker->company,
            'total_amount' => number_format(30.56, 2),
            'items' => $items,
            '_token' => $token
        ];


        $response = $this->actingAs($user)->put(route('vouchers.update', $voucher), $updatedData);

        $response->assertRedirect(route('vouchers.index'));

        $this->assertDatabaseHas('vouchers', [
            'delivery_to' => 'Name updated'
        ]);
    }

    public function test_delete_voucher() {

        $user = User::factory()->create();
        $voucher = Voucher::factory()->create(["user_id" => $user->id]);

        $this->assertDatabaseHas("vouchers", ["id" => $voucher->id]);

        $response = $this->actingAs($user)->delete(route("vouchers.destroy", $voucher->id));

        $response->assertRedirect(route("vouchers.index"));

        $this->assertDatabaseMissing("vouchers", ["id" => $voucher->id]);
    }
}
