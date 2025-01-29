<?php

namespace App\Repositories\News;

use App\Repositories\Base\EloquentBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class EloquentNewsRepository extends EloquentBaseRepository implements NewsRepository
{
    public function getPersonalizedNews(array $data = []): LengthAwarePaginator
    {
        $perPage = $data['per_page'] ?? config('app.per_page');

        // Retrieve user favorites and group them by type
        $favorites = auth()->user()->favorites->groupBy('type_name');

        // Extract authors and categories
        $authors = $favorites->get('Author', collect())->pluck('value')->unique()->toArray();
        $categories = $favorites->get('Category', collect())->pluck('value')->unique()->toArray();

        // Build and execute the query
        return $this->model->newQuery()
            ->when(!empty($authors), function ($query) use ($authors) {
                $query->whereIn('author', $authors);
            })
            ->when(!empty($categories), function ($query) use ($categories) {
                $query->orWhereIn('section', $categories);
            })
            ->paginate($perPage);
    }

}
