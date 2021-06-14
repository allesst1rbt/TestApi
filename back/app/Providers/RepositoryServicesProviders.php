<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\HomeRepository;
use App\Repositories\HomeRepositoryInterface;
use App\Repositories\ProductsRepository;
use App\Repositories\ProductsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServicesProviders extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(HomeRepositoryInterface::class,HomeRepository::class);
        $this->app->bind(ProductsRepositoryInterface::class,ProductsRepository::class);
        $this->app->bind(AuthRepositoryInterface::class,AuthRepository::class);
    }
}
