<?php

namespace App\Services\Contracts;

use App\Models\User;
use App\Models\Voucher;

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
}

