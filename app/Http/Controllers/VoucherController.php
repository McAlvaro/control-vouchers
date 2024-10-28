<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use App\Services\Contracts\IContractService;
use App\Services\Contracts\IVoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class VoucherController extends Controller
{
    private $voucherService;

    private $contractService;

    function __construct(IVoucherService $voucherService, IContractService $contractService)
    {
        $this->voucherService = $voucherService;
        $this->contractService = $contractService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $vouchers = $this->voucherService->getAll(
            $request->get('station_name') ?? null,
            $request->get('delivery_to') ?? null,
            $request->get('plate') ?? null,
            $request->get('from_date') ?? null,
            $request->get('to_date') ?? null
        );

        $contracts = $this->contractService->getCurrentContracts();

        return Inertia::render(component: 'Vouchers/Index', props: [
            'vouchers' => $vouchers,
            'contracts' => $contracts,
            'filters' => $request->only(['station_name', 'delivery_to', 'plate', 'from_date', 'to_date'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return void
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        $voucher = $this->voucherService->createVoucher(Auth::user(), $request->all());

        return redirect()->route('vouchers.index')->with('voucher', $voucher->toArray());
    }

    /**
     * Display the specified resource.
     * @return void
     */
    public function show(Voucher $voucher): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return void
     */
    public function edit(Voucher $voucher): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @return void
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $this->voucherService->updateVoucher($voucher, $request->all());

        return redirect()->route('vouchers.index')->with('success', 'Actualizado exisitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $this->voucherService->destroy($voucher);

        return redirect()->route('vouchers.index')->with('success', 'Eliminado exisitosamente');
    }
}
