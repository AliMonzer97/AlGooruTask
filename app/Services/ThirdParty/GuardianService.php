<?php

namespace App\Services\ThirdParty;

use App\HttpServices\Services\GuardianApiService;
use Illuminate\Http\Client\RequestException;

class GuardianService
{
    private GuardianApiService $guardianApi;

    public function __construct(GuardianApiService $guardianApi)
    {
        $this->guardianApi = $guardianApi;
    }

    /**
     * @throws RequestException
     */
    public function getNews(string $query = ''): mixed
    {
        return $this->guardianApi->getNews($query);
    }
}
