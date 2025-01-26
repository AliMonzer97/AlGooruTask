<?php

namespace App\UseCases\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CheckUserCredentialsUseCase extends AuthUseCase
{

    /**
     * @throws ValidationException
     */
    public function execute(array $data = []): Model
    {

        $user = $this->getUserByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $user;
    }
}
