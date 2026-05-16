<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// User Bindings
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

// Store Balance History Bindings (👈 ADDED THESE IMPORTS)
use App\Interfaces\StoreBalanceHistoryRepositoryInterface;
use App\Repositories\StoreBalanceHistoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // User Repository Mapping
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Store Balance History Mapping (👈 ADDED THIS BINDING)
        $this->app->bind(
            StoreBalanceHistoryRepositoryInterface::class, 
            StoreBalanceHistoryRepository::class
        );
    }
}