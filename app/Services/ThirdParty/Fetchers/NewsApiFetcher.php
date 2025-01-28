<?php

namespace App\Services\ThirdParty\Fetchers;

use App\Enums\NewsServices;
use App\Services\ThirdParty\NewsService;
use Illuminate\Http\Client\RequestException;

class NewsApiFetcher extends AbstractNewsFetcher
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @throws RequestException
     */
    protected function fetchFromService(): mixed
    {
        return $this->newsService->getNews();
    }

    protected function mapResponse(mixed $response): array
    {

        $newsList = [];
        foreach ($response->articles as $item) {
            $newsList[] = [
                'service' => NewsServices::NEWSAPI->value,
                'section' => $item->source->name ?? null,
                'title' => $item->title,
                'summary' => $item->description,
                'content' => $item->content,
                'author' => $item->author,
                'url' => $item->url,
                'image_url' => $item->urlToImage,
                'published_at' => $item->publishedAt,
                'external_id' => md5($item->url),
                'metadata' => json_encode($item),
            ];
        }
        return $newsList;
    }
}
