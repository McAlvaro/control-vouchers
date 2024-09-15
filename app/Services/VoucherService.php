<?php

namespace App\Services;

use App\Models\User;
use App\Models\Voucher;
use App\Services\Contracts\IVoucherService;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getAll(): LengthAwarePaginator
    {
        $vouchers = Voucher::query()->orderBy(column: 'id', direction: 'desc')->paginate(perPage: 10);

        return $vouchers;

    }
}
