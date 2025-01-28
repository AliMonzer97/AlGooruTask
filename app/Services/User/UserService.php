<?php

namespace App\Services\User;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Traits\PaginationHelper;
use App\UseCases\Auth\CheckUserCredentialsUseCase;
use Illuminate\Validation\ValidationException;

class UserService extends AuthService
{
    protected CheckUserCredentialsUseCase $checkUserCredentialsUseCase;

    use PaginationHelper;

    protected array $headers = ['id', 'name'];

    public function __construct(UserRepository $userRepository,CheckUserCredentialsUseCase $checkUserCredentialsUseCase)
    {
        parent::__construct($userRepository);
        $this->checkUserCredentialsUseCase = $checkUserCredentialsUseCase;
    }


    /**
     * @throws ValidationException
     */
    public function login(array $data): array
    {

        /** @var User $user */
        $user = $this->checkUserCredentialsUseCase->execute($data);

        return [
            'token' => $user->createToken('authToken')->plainTextToken,
            'user' => new UserResource($user)
        ];
    }

    public function logout($request): void
    {
        $request->user()->tokens()->delete();
    }


}
