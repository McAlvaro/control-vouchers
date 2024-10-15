<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Contract;
use App\Services\Contracts\IContractService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ContractController extends Controller
{
    private $contractService;

    function __construct(IContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function index(Request $request)
    {

        $contracts = $this->contractService->getAll(
            $request->get('station_name') ?? null,
            $request->get('contract_number') ?? null
        );

        return Inertia::render(component: 'Contracts/Index', props: [
            'contracts' => $contracts,
            'filters' => $request->only(['station_name', 'station_nit'])
        ]);
    }

    public  function store(StoreContractRequest $request)
    {

        $contract = $this->contractService->createContract($request->all());

        return redirect()->route('contracts.index')->with('contract', $contract->toArray());
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        Log::debug("UpdateContractRequest: " . json_encode($request->all()));

        $this->contractService->updateContract($contract, $request->all());

        return redirect()->route('contracts.index')->with('success', 'Actualizado exisitosamente');
    }

    public function destroy(Contract $contract)
    {

        $this->contractService->destroy($contract);

        return redirect()->route('contracts.index')->with('success', 'Eliminado exisitosamente');
    }
}
