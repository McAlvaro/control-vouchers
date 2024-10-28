<?php

namespace App\Services;

use App\Models\Refund;
use App\Services\Contracts\IContractService;
use App\Services\Contracts\IRefundService;
use App\Services\Contracts\IVoucherService;
use Illuminate\Pagination\LengthAwarePaginator;

class RefundService implements IRefundService
{
    private $voucherService;

    private $contractService;

    public function __construct(IVoucherService $voucherService, IContractService $contractService)
    {

        $this->voucherService = $voucherService;

        $this->contractService = $contractService;
    }

    public function createRefund(array $refundData): Refund
    {

        $voucher = $this->voucherService->getVoucherById($refundData['voucher_id']);

        $refund = $voucher->refund()->create([
            'date' => $refundData['date'],
            'invoice_number' => $refundData['invoice_number'],
            'quantity' => $refundData['quantity']
        ]);

        $this->contractService->addBalance($voucher->contract_id, $refund->quantity);

        return $refund;
    }

    public function updateRefund(Refund $refund, array $refundData): Refund
    {

        $refund->update([
            'date' => $refundData['date'],
            'invoice_number' => $refundData['invoice_number'],
            'quantity' => $refundData['quantity']
        ]);

        return $refund;
    }

    public function destroy(Refund $refund): void
    {
        $voucher = $refund->voucher;
        $quantity = $refund->quantity;

        $refund->delete();

        $this->contractService->subtractBalance($voucher->contract_id, $quantity);
    }

    public function getAll(): LengthAwarePaginator
    {
        $refunds = Refund::query()
            ->with('voucher')
            ->orderBy(column: 'id', direction: 'desc')
            ->paginate(10);

        return $refunds;
    }
}
