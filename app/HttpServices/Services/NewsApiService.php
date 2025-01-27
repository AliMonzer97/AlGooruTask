<?php

namespace App\HttpServices\Services;

use App\HttpServices\BaseService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class NewsApiService extends BaseService
{
    protected bool $directAccess = true;

    /**
     * Get the base URL for the News API.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return config('services.news_api.base_url', 'https://newsapi.org/v2');
    }

    /**
     * Prefix for the News API.
     *
     * @return string
     */
    protected function getServicePrefix(): string
    {
        return '';
    }

    /**
     * Fetch top headlines from News API.
     *
     * @param array $query
     * @return Response
     * @throws RequestException
     */
    public function getTopHeadlines(array $query = []): Response
    {
        $query = array_merge($query, ['apiKey' => config('services.news_api.api_key')]);
        return $this->get('top-headlines', $query);
    }

    /**
     * Search for news articles.
     *
     * @param array $query
     * @return Response
     * @throws RequestException
     */
    public function getNews(array $query = []): mixed
    {
        $query = array_merge($query);
        $path = 'everything?'.'q=bitcoin';
        return $this->get($path, $query);
    }
    public function getHeaders(array $headers = []): array
    {
        return array_merge(parent::getHeaders($headers),['x-api-key'=>config('services.news_api.api_key')]);
    }
}
