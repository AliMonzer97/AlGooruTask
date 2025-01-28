<?php


namespace App\Providers;

use App\Models\News\News;
use App\Models\User;
use App\Models\User\UserFavorite;
use App\Repositories\News\EloquentNewsRepository;
use App\Repositories\News\NewsRepository;
use App\Repositories\User\EloquentUserFavoriteRepository;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserFavoriteRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->app->bind(UserRepository::class, function () {
            return new EloquentUserRepository(new User());
        });

        $this->app->bind(NewsRepository::class, function () {
            return new EloquentNewsRepository(new News());
        });

        $this->app->bind(UserFavoriteRepository::class, function () {
            return new EloquentUserFavoriteRepository(new UserFavorite());
        });




    }
}
