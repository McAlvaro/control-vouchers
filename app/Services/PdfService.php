<?php

namespace App\Services;

use App\Models\Voucher;
use App\Services\Contracts\IPdfService;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PdfInstace;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PdfService implements IPdfService
{
    public function downloadVoucherPdf(Voucher $voucher): Response
    {
        $voucher->date = $this->parseDate($voucher->date);

        $pdf = $this->makePdf(data: $voucher->load('items',)->toArray(), view: 'templates.voucher');

        $filename = sprintf('vale_%s.pdf', $voucher->voucher_number);

        return $pdf->stream($filename);
    }

    /**
     * @param array<int,mixed> $data
     * @param string $view
     */
    private function makePdf(array $data, string $view): PdfInstace
    {
        $pdf = Pdf::loadView($view, ['data' => $data, 'logo' => $this->getLogoBase64()])
            ->setPaper('letter')
            ->setWarnings(true)
            ->setOptions(['isRemoteEnabled' => true]);

        return $pdf;
    }

    private function getLogoBase64() {
        return 'data:image/jpg;base64,' . base64_encode(file_get_contents(storage_path('app/public/logo.jpg')));
    }

    private function parseDate($date) {
        return Carbon::parse($date)->locale('es')->translatedFormat('l d \d\e F \d\e Y');
    }
}
