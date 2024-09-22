<?php

namespace App\Services\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DateFilter
{
    /**
     * @param Builder<Model> $builder
     * @param string $from_date
     * @param string $to_date
     * @param string $table
     * @param string $field
     */
    public static function apply(Builder $builder, string $from_date, string $to_date = null, string $table, string $field = "created_at"): Builder
    {
        $from = Carbon::parse($from_date)->startOfDay();

        if (is_null($to_date)) {

            return $builder->where("$table.$field", '>=', $from);
        }

        $to = Carbon::parse($to_date)->endOfDay();

        return $builder->whereBetween("$table.$field", [$from, $to]);
    }
}
