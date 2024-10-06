<?php

namespace App\Services\Filters\Contracts;

use App\Services\Filters\contract\Filter;
use Illuminate\Database\Eloquent\Builder;

class ContractNumberFilter implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        if (is_null($value)) {
            return $builder;
        }

        return $builder->where('contract_number', 'LIKE', "%$value%");
    }
}
