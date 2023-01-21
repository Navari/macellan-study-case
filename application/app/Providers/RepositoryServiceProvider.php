<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Location\Repositories\LocationRepository;
use Modules\Location\Repositories\LocationRepositoryInterface;
use Modules\TollGate\Repositories\TollGateRepository;
use Modules\TollGate\Repositories\TollGateRepositoryInterface;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            LocationRepositoryInterface::class,
            LocationRepository::class
        );
        $this->app->bind(
            TollGateRepositoryInterface::class,
            TollGateRepository::class
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
