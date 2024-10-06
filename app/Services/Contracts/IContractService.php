<?php

namespace App\Services\Contracts;

use App\Models\Contract;
use Illuminate\Pagination\LengthAwarePaginator;

interface IContractService
{
    /**
     * @param array $contractData
     * @return Contract
     */
    public function createContract(array $contractData): Contract;

    public function updateContract(Contract $contract, array $contractData): Contract;

    public function destroy(Contract $contract): void;

    public function getAll(string $station_name = null, string $contract_number = null): LengthAwarePaginator;
}
