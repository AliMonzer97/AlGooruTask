<?php

namespace App\Services\ThirdParty;

use App\HttpServices\Services\NewsApiService;
use Illuminate\Http\Client\RequestException;

class NewsService
{
    private NewsApiService $newsApi;

    public function __construct(NewsApiService $newsApi)
    {
        $this->newsApi = $newsApi;
    }

    /**
     * @throws RequestException
     */
    public function getNews(array $filters = []): mixed
    {
        return $this->newsApi->getNews($filters);
    }

}
