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

        $this->saveItems($voucher, $voucherData['items']);

        return $voucher->load('items');
    }

    /**
     * @param Voucher $voucher
     * @param array<int,mixed> $items
     */
    private function saveItems(Voucher $voucher, array $items): void
    {
        $voucher->items()->createMany($items);
    }
    /**
     * @param Voucher $voucher
     * @param array<int,mixed> $items
     */
    private function updateItems(Voucher $voucher, array $items): void
    {
        $existingItems = $voucher->items()->pluck('id')->toArray();
        $newItems = array_column($items, 'id');

        $itemsToDelete = array_diff($existingItems, $newItems);
        if ($itemsToDelete) {
            $voucher->items()->whereIn('id', $itemsToDelete)->delete();
        }

        // Actualizar o crear nuevos items
        foreach ($items as $item) {
            $voucher->items()->updateOrCreate(
                ['id' => $item['id'] ?? 0], // Buscar por id para actualizar
                $item // Datos del item
            );
        }
    }

    public function getAll(string $delivery_to = "", string $plate = ""): LengthAwarePaginator
    {
        $vouchers = Voucher::query()
            ->with('items')
            ->where('delivery_to', 'LIKE', "%$delivery_to%")
            ->where('plate', 'LIKE', "%$plate%")
            ->orderBy(column: 'id', direction: 'desc')
            ->paginate(perPage: 10);

        return $vouchers;
    }

    public function updateVoucher(Voucher $voucher, array $voucherData): Voucher
    {
        $voucherItems = $voucherData['items'] ?? [];

        unset($voucherData['items']);

        $voucher->update($voucherData);

        $this->updateItems($voucher, $voucherItems);

        return $voucher;
    }

    public function destroy(Voucher $voucher): void
    {
        $voucher->delete();
    }
}
