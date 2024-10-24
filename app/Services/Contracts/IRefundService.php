<?php

namespace App\Services\Contracts;

use App\Models\Refund;
use Illuminate\Pagination\LengthAwarePaginator;

interface IRefundService
{
    /**
     * @param array $refundData
     * @return Refund
     */
    public function createRefund(array $refundData): Refund;

    /**
     * @param array $refundData
     * @return Refund
     */
    public function updateRefund(Refund $refund, array $refundData): Refund;

    public function destroy(Refund $refund): void;

    public function getAll(): LengthAwarePaginator;
}
