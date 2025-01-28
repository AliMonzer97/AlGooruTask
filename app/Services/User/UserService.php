<?php

namespace App\Services\User;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Traits\PaginationHelper;
use App\UseCases\Auth\AssignRoleToUserUseCase;
use App\UseCases\Auth\CheckUserCredentialsUseCase;
use App\UseCases\Auth\CreateTokenUseCase;
use App\UseCases\User\AddToFavoritesUseCase;
use App\UseCases\User\CreateUserUseCase;
use App\UseCases\User\RemoveFromFavoritesUseCase;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class UserService extends AuthService
{
    protected CheckUserCredentialsUseCase $checkUserCredentialsUseCase;
    protected AddToFavoritesUseCase $addToFavoritesUseCase;
    protected RemoveFromFavoritesUseCase $removeFromFavoritesUseCase;
    protected CreateUserUseCase $createUserUseCase;
    protected CreateTokenUseCase $createTokenUseCase;
    protected AssignRoleToUserUseCase $assignRoleToUserUseCase;

    use PaginationHelper;

    protected array $headers = ['id', 'name'];

    public function __construct(UserRepository $userRepository,
                                CheckUserCredentialsUseCase $checkUserCredentialsUseCase,
                                AddToFavoritesUseCase $addToFavoritesUseCase,
                                RemoveFromFavoritesUseCase $removeFromFavoritesUseCase,
                                CreateUserUseCase $createUserUseCase,
                                CreateTokenUseCase $createTokenUseCase,
                                AssignRoleToUserUseCase $assignRoleToUserUseCase

    )
    {
        parent::__construct($userRepository);
        $this->checkUserCredentialsUseCase = $checkUserCredentialsUseCase;
        $this->addToFavoritesUseCase = $addToFavoritesUseCase;
        $this->removeFromFavoritesUseCase = $removeFromFavoritesUseCase;
        $this->createUserUseCase = $createUserUseCase;
        $this->createTokenUseCase = $createTokenUseCase;
        $this->assignRoleToUserUseCase = $assignRoleToUserUseCase;
    }


    public function register(array $data): array
    {
        $role = $data['role'];
        unset($data['role']);
        DB::beginTransaction();
        try {
            $user = $this->createUserUseCase->execute($data);
            $this->assignRoleToUserUseCase->execute($user,$role);
            $token = $this->createTokenUseCase->execute($user);
            $user->load('roles');
            DB::commit();
            return [
                'token' => $token,
                'user' => new UserResource($user)
            ];
        }
        catch (Exception $exception) {
            DB::rollBack();
            Log::error('Error during registration: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new RuntimeException('An error occurred during registration. Please try again.', 500);
        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function login(array $data): array
    {

        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = $this->checkUserCredentialsUseCase->execute($data);
            $token = $this->createTokenUseCase->execute($user);
            $user->load('roles');
            DB::commit();
            return [
                'token' => $token,
                'user' => new UserResource($user)
            ];
        }
        catch (Exception $exception) {
            DB::rollBack();
            Log::error('Error during login: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new RuntimeException('An error occurred during login. Please try again.', 500);
        }

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
