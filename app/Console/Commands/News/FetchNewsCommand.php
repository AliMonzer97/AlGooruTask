<?php

namespace App\Console\Commands\News;

use App\Enums\NewsServices;
use App\Repositories\News\NewsRepository;
use App\Services\ThirdParty\Factories\NewsFetcherFactory;
use Illuminate\Console\Command;


class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch news from external services and store them in the database';

    public function handle(): void
    {
        $services = NewsServices::cases();

        foreach ($services as $serviceEnum) {
            $service = $serviceEnum->value;

            $fetcher = NewsFetcherFactory::createFetcher($service);

            $newsList = $fetcher->fetchAndMapNews();
            foreach ($newsList as $newsItem) {
                app(NewsRepository::class)->updateOrCreate(
                    ['external_id' => $newsItem['external_id']],
                    $newsItem
                );
            }
        }

        $this->info('News fetched and stored successfully.');
    }
}

