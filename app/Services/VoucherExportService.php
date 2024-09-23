<?php

namespace App\Services;

use App\Exports\VouchersExport;
use App\Services\Contracts\IVouherExportService;
use Carbon\Carbon;

class VoucherExportService implements IVouherExportService
{
    public function exportVouchersToExcel(string $delivery_to = null, string $plate = null, string $from_date = null, string $to_date = null)
    {
        $filename = sprintf('reporte_vales_%s', Carbon::now()->toDateString());

        return (new VouchersExport(
            $delivery_to,
            $plate,
            $from_date,
            $to_date
        ))->download("$filename.xlsx");
    }
}
