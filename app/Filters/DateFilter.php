<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class DateFilter extends Filter
{
    public function apply(Builder $query, string $column, $value): Builder
    {

        if (isset($value['from'])) {
            $query->whereDate($column, '>=', $value['from']);
        }
        if (isset($value['to'])) {
            $query->whereDate($column, '<=', $value['to']);
        }

        return $query;
    }
}
