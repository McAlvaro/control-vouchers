<?php

namespace App\Traits;

trait StaticTableName
{
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }
}
