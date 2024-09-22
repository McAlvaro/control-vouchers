<?php

namespace App\Services\Filters\Vouchers;

use App\Services\Filters\contract\Filter;
use Illuminate\Database\Eloquent\Builder;

class PlateFilter implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        if (is_null($value)) {
            return $builder;
        }

        return $builder->where('plate', 'LIKE', "%$value%");
    }
}
