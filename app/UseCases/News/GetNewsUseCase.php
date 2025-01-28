<?php

namespace App\UseCases\News;

use App\Http\Resources\News\NewsResource;
use App\Traits\PaginationHelper;
use App\Traits\SortHelper;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetNewsUseCase extends NewsUseCase
{

    use PaginationHelper, SortHelper;

    protected array $attributes = []; // Filtering conditions
    protected string $resource = NewsResource::class; // Resource class for transforming data

    protected array $with = []; // Relationships to eager load
    protected array $columns = ['*']; // Columns to select in the query
    protected string $orderBy = 'id'; // Default sorting column
    protected array $headers = []; // Additional headers for the response


    /**
     * Executes the get news logic.
     *
     * @param array $data Request data containing query parameters and filters.
     * @return mixed Paginated and transformed news data.
     * @throws \Exception
     */
    public function execute(array $data = []): mixed
    {
        $this->prepareConditions($data);

        $data = $this->prepareNewsData($data);

        return $this->handle($data);

    }

    /**
     * Handles the query execution and data transformation.
     *
     * @param array $data Query parameters and filters.
     * @return AnonymousResourceCollection|array Paginated data wrapped in a resource collection.
     * @throws \Exception
     */
    public function handle(array $data = []):mixed
    {
        $result = $this->newsRepository
            ->paginate(
                $data['per_page'] ?? config('app.per_page'),
                $this->attributes,
                $this->with,
                $this->columns,
                $this->prepareSort()
            );

        return $this->getPaginatedData($this->headers,$result,$this->resource);
    }

    /**
     * Prepares additional data for the query.
     *
     * @param array $data Query parameters and filters.
     * @return array Modified or additional data for the query.
     */
    public function prepareNewsData( array $data = []): array
    {
        return $data;
    }

    /**
     * Prepares conditions for querying the news repository.
     *
     * @param array $data
     * @return void
     */
    public function prepareConditions(array $data): void
    {
        // Set default attributes as an empty array (can be modified based on input)
        $this->attributes = [];
    }
}
