<?php

namespace App\Services\Filters\Vouchers;

use App\Services\Filters\contract\Filter;
use Illuminate\Database\Eloquent\Builder;

class StationNameFilter implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        if (is_null($value)) {
            return $builder;
        }

        return $builder->where('station_name', 'LIKE', "%$value%");
    }
}
