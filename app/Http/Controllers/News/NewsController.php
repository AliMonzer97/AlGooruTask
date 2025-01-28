<?php

namespace App\Http\Controllers\News;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\GetNewsRequest;
use App\Services\News\NewsService;
use App\UseCases\News\GetNewsUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected NewsService $newsService;
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @throws \Exception
     */
    public function index(GetNewsRequest $request): JsonResponse
    {
        $services = $this->newsService->index($request->validated());
        return ApiResponse::success($services);
    }
}
