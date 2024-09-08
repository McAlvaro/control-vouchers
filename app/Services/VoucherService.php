<?php

namespace App\Services;

use App\Models\User;
use App\Models\Voucher;
use App\Services\Contracts\IVoucherService;

class VoucherService implements IVoucherService
{
    public function createVoucher(User $user, array $voucherData): Voucher
    {
        $voucher = Voucher::query()->create([
            'date' => $voucherData['date'],
            'delivery_to' => $voucherData['delivery_to'],
            'vehicle' => $voucherData['vehicle'],
            'plate' => $voucherData['plate'],
            'kilometer' => $voucherData['kilometer'],
            'station_name' => $voucherData['station_name'],
            'total_amount' => $voucherData['total_amount'],
            'user_id' => $user->id
        ]);

        $this->createItems($voucher, $voucherData['items']);

        return $voucher->load('items');
    }

    /**
     * @param Voucher $voucher
     * @param array<int,mixed> $items
     */
    private function createItems(Voucher $voucher, array $items): void
    {
        $voucher->items()->createMany($items);
    }
}
