<?php

namespace App\UseCases\News;

use App\Repositories\News\NewsRepository;

class NewsUseCase
{

    protected NewsRepository $newsRepository;
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
}
