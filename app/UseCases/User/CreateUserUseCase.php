<?php

namespace App\UseCases\User;

use App\Repositories\User\UserRepository;
use App\UseCases\Model\StoreModelUseCase;
use Illuminate\Support\Facades\Hash;

class CreateUserUseCase extends StoreModelUseCase
{

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function prepareData(array $data = []): array
    {
        $data['password'] = Hash::make($data['password']);
        return $data;
    }
}
