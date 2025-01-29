<?php

namespace App\Filters\Types;

use App\Filters\DateFilter;
use App\Filters\GreaterThanFilter;
use App\Filters\LikeFilter;

class NewsFilterFactory extends FilterFactory
{
    protected static array $filterMap = [
        'author'=> LikeFilter::class,
        'section'=> LikeFilter::class,
        'published_at'=> GreaterThanFilter::class,
    ];

    public static function getValidationRules(): array
    {
        return collect(self::$filterMap)->mapWithKeys(fn($filterClass, $field) => [
            "filters.$field" => match ($filterClass) {
                LikeFilter::class => ['nullable', 'string', 'max:255'],
                DateFilter::class => ['nullable', 'date', 'before_or_equal:today'],
                default => ['nullable'],
            }
        ])->toArray();
    }

}
