<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use App\Services\Contracts\IVoucherService;
use Illuminate\Support\Facades\Auth;
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
     */
    public function store(StoreVoucherRequest $request)
    {
        $voucher = $this->voucherService->createVoucher(Auth::user(), $request->all());

        return redirect()->route('vouchers.index')->with('success', 'Voucher creado exisitosamente');
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
