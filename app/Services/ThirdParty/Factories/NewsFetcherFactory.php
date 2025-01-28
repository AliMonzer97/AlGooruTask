<?php

namespace App\Services\ThirdParty\Factories;

use App\Enums\NewsServices;
use App\Services\ThirdParty\Fetchers\AbstractNewsFetcher;
use App\Services\ThirdParty\Fetchers\GuardianNewsFetcher;
use App\Services\ThirdParty\Fetchers\NewsApiFetcher;
use InvalidArgumentException;

class NewsFetcherFactory
{
    public static function createFetcher(int $service): AbstractNewsFetcher
    {
        return match ($service) {
            NewsServices::GUARDIAN->value => app(GuardianNewsFetcher::class),
            NewsServices::NEWSAPI->value => app(NewsApiFetcher::class),
            default => throw new InvalidArgumentException('Unsupported news service'),
        };
    }
}

