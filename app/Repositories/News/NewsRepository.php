<?php

namespace App\Repositories\News;

use App\Repositories\Base\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NewsRepository extends BaseRepository
{
    public function getPersonalizedNews(array $data = []);
    public function getGuestNews(array $data = [],int $perPage = 15, ?array $conditions = null, ?array $with = null, array $columns = ['*'], $order = null): LengthAwarePaginator;

}
