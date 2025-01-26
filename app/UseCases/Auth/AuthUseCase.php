<?php

namespace App\UseCases\Auth;

use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;

abstract class AuthUseCase
{


    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    protected function getUserByEmail(string $email): ?Model
    {
        return $this->userRepository->findByAttributes(['email' => $email]);
    }


}
