<?php

namespace App\HttpServices\Services;

use App\HttpServices\BaseService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class GuardianApiService extends BaseService
{
    protected bool $directAccess = true;

    /**
     * Get the base URL for The Guardian API.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return config('services.guardian_api.base_url', 'https://content.guardianapis.com');
    }

    /**
     * Prefix for The Guardian API.
     *
     * @return string
     */
    protected function getServicePrefix(): string
    {
        return '';
    }

    /**
     * Fetch content from The Guardian API.
     *
     * @param array $query
     * @return Response
     * @throws RequestException
     */
    public function getContent(array $query = []): Response
    {
        $query = array_merge($query, ['api-key' => config('services.guardian_api.api_key')]);
        return $this->get('', $query);
    }

    /**
     * Search content by query.
     *
     * @param string $queryString
     * @param array $additionalParams
     * @return mixed
     * @throws RequestException
     */
    public function getNews(string $queryString = '', array $additionalParams = []): mixed
    {
        $query = array_merge(['q' => $queryString], $additionalParams);

        $path = 'search?'.'api-key='.config('services.guardian_api.api_key');

        return $this->get($path, $query);
    }
}
