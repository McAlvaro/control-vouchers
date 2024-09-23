<?php

namespace App\Services\Contracts;

interface IVouherExportService
{
    public function exportVouchersToExcel(string $delivery_to = null, string $plate = null, string $from_date = null, string $to_date = null);
}
