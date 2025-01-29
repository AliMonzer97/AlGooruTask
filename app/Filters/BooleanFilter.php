<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BooleanFilter extends Filter
{
    public function apply(Builder $query, string $column, $value): Builder
    {
        return $query->where($column, (bool) $value);
    }
}
