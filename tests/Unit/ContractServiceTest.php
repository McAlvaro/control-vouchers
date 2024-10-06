<?php

namespace Tests\Unit;

use App\Models\Contract;
use App\Services\Contracts\IContractService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ContractServiceTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_create_contract(): void
    {
        $contractData = [
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

        $contractService = app(IContractService::class);

        $contract = $contractService->createContract($contractData);

        $this->assertDatabaseHas(table: 'contracts', data: ['id' => $contract->id]);
    }

    public function test_update_contract(): void
    {

        $contract = Contract::factory()->create();

        $contractDataUpdate = [
            'station_name' => 'Station Name Updated',
        ];

        $contractService = app(IContractService::class);

        $contract = $contractService->updateContract($contract, $contractDataUpdate);

        $this->assertDatabaseHas(table: 'contracts', data: ['id' => $contract->id, 'station_name' => $contractDataUpdate['station_name']]);

    }

    public function test_destroy_contract(): void
    {
        $contract = Contract::factory()->create();

        $contractService = app(IContractService::class);

        $contractService->destroy($contract);

        $this->assertDatabaseMissing(table: 'contracts', data: ['id' => $contract->id]);
    }

    public function test_get_all_contracts(): void
    {
        Contract::factory()->count(25)->create();

        $contractService = app(IContractService::class);

        $paginatedContracts = $contractService->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $paginatedContracts);
        $this->assertEquals(10, $paginatedContracts->perPage());
        $this->assertEquals(25, $paginatedContracts->total());
        $this->assertGreaterThan(0, $paginatedContracts->count());
    }
}
