<?php

namespace App\Services;

use App\Models\Contract;
use App\Services\Contracts\IContractService;
use App\Services\Filters\Contracts\ContractNumberFilter;
use App\Services\Filters\Contracts\StationNameFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ContractService implements IContractService
{
    public function createContract(array $contractData): Contract
    {
        $contract = Contract::query()->create($contractData);

        return $contract;
    }

    public function updateContract(Contract $contract, array $contractData): Contract
    {
        $contract->update($contractData);

        return $contract;
    }

    public function destroy(Contract $contract): void
    {
        $contract->delete();
    }

    public function getAll(string $station_name = null, string $contract_number = null): LengthAwarePaginator
    {
        $query = Contract::query()
            ->orderBy(column: 'id', direction: 'desc');

        $query = StationNameFilter::apply($query, $station_name);

        $query = ContractNumberFilter::apply($query, $contract_number);

        return $query->paginate(10);
    }

    public function getCurrentContracts(): Collection
    {
        $now = Carbon::now()->toDateString();

        $contracts = Contract::query()
            ->where('end_date', '>=', $now)
            ->get();

        return $contracts;
    }

    public function subtractBalance(int $contract_id, int $quantity): void
    {

        $contract = Contract::query()->where('id', $contract_id)->first();

        $contract->update([
            'balance' => $contract->balance - $quantity
        ]);
    }

    public function addBalance(int $contract_id, int $quantity): void
    {

        $contract = Contract::query()->where('id', $contract_id)->first();

        $contract->update([
            'balance' => $contract->balance + $quantity
        ]);
    }
}
