<?php

namespace App\Services\Contracts;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Pagination\LengthAwarePaginator;

interface IVoucherService
{
    /**
     * Crear un nuevo voucher.
     *
     * @param User $user usuario auntenticado.
     * @param array $voucherData Los datos necesarios para crear el voucher.
     * @return Voucher
     */
    public function createVoucher(User $user, array $voucherData): Voucher;

    public function updateVoucher(Voucher $voucher, array $voucherData): Voucher;

    public function destroy(Voucher $voucher): void;

    public function getAll(string $station_name = null, string $delivery_to = null, string $plate = null, string $from_date = null, string $to_date = null): LengthAwarePaginator;

    public function getVoucherById(int $voucher_id): Voucher;
}

