<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
