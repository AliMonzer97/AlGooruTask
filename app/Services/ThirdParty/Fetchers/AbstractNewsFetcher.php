<?php

namespace App\Services\ThirdParty\Fetchers;

abstract class AbstractNewsFetcher
{
    /**
     * Fetch news and map it to the database structure.
     */
    public function fetchAndMapNews(): array
    {
        $response = $this->fetchFromService();
        return $this->mapResponse($response);
    }

    /**
     * Fetch news from the external service.
     */
    abstract protected function fetchFromService(): mixed;

    /**
     * Map the service response to the database structure.
     */
    abstract protected function mapResponse(mixed $response): array;
}

