<?php

namespace App\Services\User;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Traits\PaginationHelper;
use App\UseCases\Auth\CheckUserCredentialsUseCase;
use App\UseCases\User\AddToFavoritesUseCase;
use App\UseCases\User\RemoveFromFavoritesUseCase;
use Illuminate\Validation\ValidationException;

class UserService extends AuthService
{
    protected CheckUserCredentialsUseCase $checkUserCredentialsUseCase;
    protected AddToFavoritesUseCase $addToFavoritesUseCase;
    protected RemoveFromFavoritesUseCase $removeFromFavoritesUseCase;

    use PaginationHelper;

    protected array $headers = ['id', 'name'];

    public function __construct(UserRepository $userRepository,
                                CheckUserCredentialsUseCase $checkUserCredentialsUseCase,
                                AddToFavoritesUseCase $addToFavoritesUseCase,
                                RemoveFromFavoritesUseCase $removeFromFavoritesUseCase

    )
    {
        parent::__construct($userRepository);
        $this->checkUserCredentialsUseCase = $checkUserCredentialsUseCase;
        $this->addToFavoritesUseCase = $addToFavoritesUseCase;
        $this->removeFromFavoritesUseCase = $removeFromFavoritesUseCase;
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

    public function addToFavorites(array $data)
    {
        return $this->addToFavoritesUseCase->execute($data);
    }
    public function removeFromFavorites(array $data)
    {
        return $this->removeFromFavoritesUseCase->execute($data);
    }



}
