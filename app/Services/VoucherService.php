<?php

namespace App\Services;

use App\Models\User;
use App\Models\Voucher;
use App\Services\Contracts\IContractService;
use App\Services\Contracts\IVoucherService;
use App\Services\Filters\DateFilter;
use App\Services\Filters\Vouchers\DeliveryToFilter;
use App\Services\Filters\Vouchers\PlateFilter;
use App\Services\Filters\Vouchers\StationNameFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class VoucherService implements IVoucherService
{
    private $contractService;

    public function __construct(IContractService $contractService)
    {
        $this->contractService = $contractService;
    }

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
            'contract_id' => $voucherData['contract_id'],
            'user_id' => $user->id
        ]);

        $this->saveItems($voucher, $voucherData['items']);

        $this->contractService->subtractBalance(
            $voucher->contract_id,
            collect($voucherData['items'])->sum('quantity')
        );

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

        foreach ($items as $item) {
            $voucher->items()->updateOrCreate(
                ['id' => $item['id'] ?? 0], // Buscar por id para actualizar
                $item // Datos del item
            );
        }
    }

    public function getAll(string $station_name = null, string $delivery_to = null, string $plate = null, string $from_date = null, string $to_date = null): LengthAwarePaginator
    {
        $query = Voucher::query()
            ->with(['items', 'refund'])
            ->orderBy(column: 'id', direction: 'desc');

        $query = StationNameFilter::apply($query, $station_name);

        $query = DeliveryToFilter::apply($query, $delivery_to);

        $query = PlateFilter::apply($query, $plate);

        if (! is_null($from_date)) {
            $query = DateFilter::apply($query, $from_date, $to_date, Voucher::getTableName(), 'date');
        }

        return $query->paginate(10);
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
        $voucher->refund()->delete();

        $voucher->delete();
    }

    public function getVoucherById(int $voucher_id): Voucher
    {
        return Voucher::query()
            ->where('id', $voucher_id)
            ->first();
    }
}
