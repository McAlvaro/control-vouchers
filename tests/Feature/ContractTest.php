<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ContractTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $user = User::factory()->create();
        $this->actingAs(user: $user);

        Contract::factory()->count(2)->create();

        $response = $this->get(route(name: 'contracts.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn(Assert $page) => $page
            ->component('Contracts/Index')
            ->has('contracts.data', 2));
    }

    public  function test_it_can_store_a_contract()
    {
        $user = User::factory()->create();

        $csrf_token = csrf_token();

        $contractData = [
            'station_name' => $this->faker->company,
            'station_nit' => strval($this->faker->randomNumber(8)),
            'city' => $this->faker->city,
            'contract_number' => strval($this->faker->randomNumber(8)),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 1, 5),
            'total_amount' => $this->faker->randomFloat(2, 50, 200),
            '_token' => $csrf_token
        ];

        $response = $this->actingAs(user: $user)
            ->post(route(name: 'contracts.store'), $contractData);

        $response->assertRedirect(uri: route('contracts.index'));

        $this->assertDatabaseHas('contracts', [
            'station_name' => $contractData['station_name'],
        ]);
    }

    public function test_it_validates_store_request()
    {
        $user = User::factory()->create();

        $csrf_token = csrf_token();

        $contractData = [
            'station_nit' => $this->faker->randomNumber(8),
            'city' => $this->faker->city,
            'contract_number' => strval($this->faker->randomNumber(8)),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 1, 5),
            'total_amount' => $this->faker->randomFloat(2, 50, 200),
            '_token' => $csrf_token
        ];

        $response = $this->actingAs(user: $user)
            ->post(route(name: 'contracts.store'), $contractData);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['station_name']);
    }

    public function test_it_can_update_a_contract(): void
    {
        $user = User::factory()->create();

        $csrf_token = csrf_token();

        $contractData = [
            'station_name' => $this->faker->company,
            'station_nit' => $this->faker->randomNumber(8),
            'city' => $this->faker->city,
            'contract_number' => $this->faker->randomNumber(8),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 1, 5),
            'total_amount' => $this->faker->randomFloat(2, 50, 200),
        ];

        $contract = Contract::factory()->create($contractData);

        $contractDataUpdate = [
            'station_name' => 'Station Name Updated',
            'station_nit' => strval($this->faker->randomNumber(8)),
            'city' => $this->faker->city,
            'contract_number' => strval($this->faker->randomNumber(8)),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 1, 5),
            'total_amount' => $this->faker->randomFloat(2, 50, 200),
            '_token' => $csrf_token
        ];

        $response = $this->actingAs(user: $user)
            ->put(route('contracts.update', $contract), $contractDataUpdate);

        $response->assertRedirect(route('contracts.index'));

        $this->assertDatabaseHas('contracts', [
            'station_name' => $contractDataUpdate['station_name']
        ]);
    }

    public function test_delete_contract() {
        $user = User::factory()->create();
        $contract = Contract::factory()->create();

        $this->assertDatabaseHas('contracts', ['id' => $contract->id]);

        $response = $this->actingAs(user: $user)->delete(route('contracts.destroy', $contract));

        $response->assertRedirect(route('contracts.index'));

        $this->assertDatabaseMissing('contracts', ['id' => $contract->id]);
    }
}
