<?php

namespace App\Repositories\News;

use App\Filters\Types\NewsFilterFactory;
use App\Repositories\Base\EloquentBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class EloquentNewsRepository extends EloquentBaseRepository implements NewsRepository
{
    public function getPersonalizedNews(array $data = []): LengthAwarePaginator
    {
        $perPage = $data['per_page'] ?? config('app.per_page');

        $favorites = auth()->user()?->favorites->groupBy('type_name');

        $authors = $favorites?->get('Author', collect())->pluck('value')->unique()->toArray() ?? [];
        $categories = $favorites?->get('Category', collect())->pluck('value')->unique()->toArray() ?? [];

        $query = $this->model->newQuery();

        if (!empty($authors) || !empty($categories)) {
            $query->where(function ($q) use ($authors, $categories) {
                if (!empty($authors)) {
                    $q->whereIn('author', $authors);
                }
                if (!empty($categories)) {
                    $q->orWhereIn('section', $categories);
                }
            });
        }

        $query = $this->applyFilters($query, $data);

        return $query->paginate($perPage);
    }

    public function applyFilters($query, $data)
    {
        return isset($data['filters']) ? NewsFilterFactory::applyFilters($query, $data['filters']) : $query;
    }

}
