<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use App\Services\Contracts\IVoucherService;
use Inertia\Inertia;
use Inertia\Response;

class VoucherController extends Controller
{
    private $voucherService;

    function __construct(IVoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $vouchers = $this->voucherService->getAll();
        return Inertia::render(component: 'Vouchers/Index', props: [
            'vouchers' => $vouchers
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
     * @return void
     */
    public function store(StoreVoucherRequest $request): void
    {
        //
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
    public function update(UpdateVoucherRequest $request, Voucher $voucher): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return void
     */
    public function destroy(Voucher $voucher): void
    {
        //
    }
}
