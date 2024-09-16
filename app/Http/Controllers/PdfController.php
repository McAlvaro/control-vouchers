<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Services\Contracts\IPdfService;
use Illuminate\Http\Response;

class PdfController
{
    private IPdfService $pdfService;

    function __construct(IPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * @return Response
     */
    public function printPdfVoucher(Voucher $voucher): Response
    {

        return $this->pdfService->downloadVoucherPdf(voucher: $voucher);
    }
}
