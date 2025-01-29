<?php

namespace App\Repositories\News;

use App\Repositories\Base\BaseRepository;

interface NewsRepository extends BaseRepository
{
    public function getPersonalizedNews(array $data = []);

}
