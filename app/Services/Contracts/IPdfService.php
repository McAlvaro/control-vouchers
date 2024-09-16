<?php

namespace App\Services\Contracts;

use App\Models\Voucher;
use Illuminate\Http\Response;

interface IPdfService
{
    /**
     * @param array<int,mixed> $data
     * @param string view
     * @return Response
     */
    public function downloadVoucherPdf(Voucher $voucher): Response;
}
