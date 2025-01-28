<?php

namespace App\UseCases\User;

use App\Enums\FavoriteTypes;
use App\Repositories\User\UserFavoriteRepository;
use App\UseCases\Model\InsertModelUseCase;

class AddToFavoritesUseCase extends InsertModelUseCase
{
    public function __construct(UserFavoriteRepository $repository)
    {
        parent::__construct($repository);
    }

    public function prepareData(array $data = []): array
    {
        $userId = auth()->id();
        $data['favorites'] = array_map(function ($favorite) use ($userId) {
            $favorite['user_id'] = $userId;
            $favorite['type'] = FavoriteTypes::fromName($favorite['type']);
            return $favorite;
        }, $data['favorites']);

        return $data['favorites'];
    }
}
