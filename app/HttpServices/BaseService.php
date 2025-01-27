<?php

namespace App\HttpServices;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Client\RequestException;

abstract class BaseService implements ServiceInterface
{
    protected mixed $baseUrl;
    protected bool $directAccess = false;

    public function __construct()
    {
        $this->baseUrl = $this->directAccess
            ? $this->getBaseUrl()
            : config('microservice.api_gateway_url') . '/api';

    }

    /**
     * @param string $method
     * @param string $path
     * @param array $options
     * @return mixed
     * @throws RequestException
     */
    protected function request(string $method, string $path, array $options = []): mixed
    {

        $url = rtrim($this->baseUrl, '/')  . trim($this->getServicePrefix(), '/') . '/' . ltrim($path, '/');
        Log::info('Request URL:', ['url' => $url]);
        Log::info('Headers:', $this->getHeaders());

        try {
            $response = Http::withHeaders($this->getHeaders())->$method($url);
            $response->throw();
        } catch (RequestException $e) {
            Log::error('HTTP Request failed:', ['error' => $e->getMessage()]);
            throw $e;
        }
        return json_decode($response);
    }

    public function getHeaders(array $headers = []): array
    {
        return $headers;
    }

    abstract protected function getServicePrefix(): string;

    /**
     * @throws RequestException
     */
    public function get(string $path, array $query = []): mixed
    {
        return $this->request('get', $path, ['query' => $query]);
    }

    /**
     * @throws RequestException
     */
    public function post(string $path, mixed $data = []): Response
    {
        return $this->request('post', $path, ['json' => $data]);
    }

    /**
     * @throws RequestException
     */
    public function put(string $path, array $data = []): Response
    {
        return $this->request('put', $path, ['json' => $data]);
    }

    /**
     * @throws RequestException
     */
    public function delete(string $path): Response
    {
        return $this->request('delete', $path);
    }

    /**
     * @throws RequestException
     */
    public function patch(string $path, array $data = []): Response
    {
        return $this->request('patch', $path, ['json' => $data]);
    }

    protected function getBaseUrl(): string
    {
        return config('services.default_base_url', '');
    }
}
