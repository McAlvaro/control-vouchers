<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IContractService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private IContractService $contractService;

    public function __construct(IContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function index()
    {
        $contracts = $this->contractService->getCurrentContracts();

        return Inertia::render(component: 'Dashboard', props: ['contracts' => $contracts]);
    }
}
