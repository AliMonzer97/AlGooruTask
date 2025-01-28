<?php

namespace App\UseCases\User;

use App\Repositories\User\UserFavoriteRepository;
use App\UseCases\Model\DestroyManyModelsUseCase;

class RemoveFromFavoritesUseCase extends DestroyManyModelsUseCase
{
    public function __construct(UserFavoriteRepository $repository)
    {
        parent::__construct($repository);
    }

    public function prepareData(array $data = []): array
    {
        $this->ids = array_map('intval', explode(',', $data['ids']));
        return $data;
    }


}
