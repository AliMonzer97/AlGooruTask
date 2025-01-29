<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class RangeFilter extends Filter
{
    public function apply(Builder $query, string $column, $value): Builder
    {
        if (isset($value['from'])) {
            $query->where($column, '>=', $value['from']);
        }
        if (isset($value['to'])) {
            $query->where($column, '<=', $value['to']);
        }

        return $query;
    }
}
