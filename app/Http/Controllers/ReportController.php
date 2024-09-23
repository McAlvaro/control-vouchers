<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IVouherExportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $exportService;

    public function __construct(IVouherExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function downloadVochersToExcel(Request $request)
    {
        return $this->exportService->exportVouchersToExcel(
            delivery_to: $request->get('delivery_to') ?? null,
            plate: $request->get('plate') ?? null,
            from_date: $request->get('from_date') ?? null,
            to_date: $request->get('to_date') ?? null
        );
    }
}
