<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Http\Requests\User\AddToFavoritesRequest;
use App\Http\Requests\User\LoginAdminRequest;
use App\Http\Requests\User\RemoveFromFavoritesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    /**
     * @throws ValidationException
     */
    public function login(LoginAdminRequest $request): JsonResponse
    {
        $data = $this->service->login($request->validated());
        return ApiResponse::success($data);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request);
        return ApiResponse::success([], 'Logged out successfully.');

    }

    public function addToFavorites(AddToFavoritesRequest $request): JsonResponse
    {

        $result = $this->service->addToFavorites($request->validated());
        return ApiResponse::success($result, 'favorites added successfully.');
    }

    public function removeFromFavorites(RemoveFromFavoritesRequest $request): JsonResponse
    {
        $result = $this->service->removeFromFavorites($request->validated());
        return ApiResponse::success($result, 'favorites deleted successfully.');
    }



}
