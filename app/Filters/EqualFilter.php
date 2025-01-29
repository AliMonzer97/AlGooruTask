<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class EqualFilter extends Filter
{
    public function apply(Builder $query, string $column, $value): Builder
    {
        return $query->where($column, $value);
    }
}
