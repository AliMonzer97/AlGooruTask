<?php

namespace App\Services\ThirdParty\Fetchers;

use App\Enums\NewsServices;
use App\Services\ThirdParty\GuardianService;
use Illuminate\Http\Client\RequestException;

class GuardianNewsFetcher extends AbstractNewsFetcher
{
    private GuardianService $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        $this->guardianService = $guardianService;
    }

    /**
     * @throws RequestException
     */
    protected function fetchFromService(): mixed
    {
        return $this->guardianService->getNews();
    }

    protected function mapResponse(mixed $response): array
    {

        $newsList = [];
        foreach ($response->response->results as $item) {
            $newsList[] = [
                'service' => NewsServices::GUARDIAN->value,
                'section' => $item->sectionName ?? null,
                'title' => $item->webTitle,
                'summary' => null,
                'content' => null,
                'author' => null,
                'url' => $item->webUrl,
                'image_url' => null,
                'published_at' => $item->webPublicationDate,
                'external_id' => $item->id,
                'metadata' => json_encode($item),
            ];
        }
        return $newsList;
    }
}

