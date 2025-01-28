<?php

namespace App\UseCases\Auth;

use App\Models\User;

class CreateTokenUseCase
{

    public function execute(User$user): string
    {
        return $user->createToken('authToken')->plainTextToken;
    }
}
