<?php

namespace App\Exports;

use App\Models\Voucher;
use App\Services\Filters\DateFilter;
use App\Services\Filters\Vouchers\DeliveryToFilter;
use App\Services\Filters\Vouchers\PlateFilter;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VouchersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    private $delivery_to;
    private $plate;
    private $from_date;
    private $to_date;

    public function __construct(string $delivery_to = null, string $plate = null, string $from_date = null, string $to_date = null)
    {
        $this->delivery_to = $delivery_to;
        $this->plate = $plate;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function query()
    {
        $query = Voucher::query()
            ->with('items')
            ->orderBy(column: 'id', direction: 'desc');

        $query = DeliveryToFilter::apply($query, $this->delivery_to);

        $query = PlateFilter::apply($query, $this->plate);

        if (! is_null($this->from_date)) {
            $query = DateFilter::apply($query, $this->from_date, $this->to_date, Voucher::getTableName(), 'date');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            '#',
            'fecha',
            'chofer',
            'vehiculo',
            'placa',
            'kilometraje',
            'estacion',
            'combustible',
            'cantidad',
            'precio',
            'subtotal',
            'total'
        ];
    }

    public function map($row): array
    {
        $columns = [];

        $items = collect($row->items)->select(['description', 'quantity', 'unit_price', 'total_price'])->all();

        foreach ($items as $index => $item) {
            if($index == 0){
                $columns[] = [
                    $row->voucher_number,
                    $row->date,
                    $row->delivery_to,
                    $row->vehicle,
                    $row->plate,
                    $row->kilometer,
                    $row->station_name,
                    ...$item,
                    $row->total_amount
                ];
            } else {

                $columns[] = [
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    ...$item,
                    $row->total_amount
                ];
            }
        }

        return $columns;
    }
}
