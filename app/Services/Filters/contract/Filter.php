<?php

namespace App\Services\Filters\contract;

use Illuminate\Database\Eloquent\Builder;


interface Filter
{
    /**
     * @param Builder $builder
     * @param mixed $value
     *
     * @return Builder
     */
    public static function apply(Builder $builder, $value);
}
