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

//        $path = 'search?'.'api-key='.config('services.guardian_api.api_key');
        $path = $this->buildPath();

        return $this->get($path, $query);
    }

    /**
     * Build query parameters with default values.
     *
     * @param array $query
     * @return array
     */
    /**
     * Build the API path with dynamic query parameters.
     *
     * @return string
     */
    private function buildPath(): string
    {
        $query = [];
        $defaultParams = [

            'from-date' => now()->subHour()->toIso8601String(),
            'to-date' => now()->toIso8601String(),
        ];

        $params = array_merge($defaultParams, $query);

        return 'search?'.'api-key='.config('services.guardian_api.api_key').'&' . http_build_query($params);
    }
}
