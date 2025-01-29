<?php

namespace App\UseCases\News;

class GetPersonalizedNewsUseCase extends GetNewsUseCase
{

    public function handle(array $data = []): mixed
    {
        $news = $this->newsRepository->getPersonalizedNews($data);
        return $this->getPaginatedData($this->headers,$news,$this->resource);
    }
}
