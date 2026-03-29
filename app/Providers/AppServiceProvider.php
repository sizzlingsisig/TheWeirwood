<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('create-houses', function ($user) {
            return $user && $user->isAdmin();
        });

        Gate::define('edit-houses', function ($user) {
            return $user && $user->isAdmin();
        });

        Gate::define('delete-houses', function ($user) {
            return $user && $user->isAdmin();
        });

        Gate::define('play-games', function ($user) {
            return $user && $user->players()->exists();
        });
    }
}
