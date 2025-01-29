<?php

namespace App\Filters\Types;

abstract class FilterFactory
{
    protected static array $filterMap = [];

    public static function applyFilters($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (!empty($value) && isset(static::$filterMap[$key])) {
                $filterClass = static::$filterMap[$key];
                (new $filterClass())->apply($query, $key, $value);
            }
        }

        return $query;
    }
}
