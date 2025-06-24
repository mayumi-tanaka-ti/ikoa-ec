<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ここでIlluminateのAuthenticateを自作Authenticateにバインド
        $this->app->bind(
            \Illuminate\Auth\Middleware\Authenticate::class,
            \App\Http\Middleware\Authenticate::class
        );
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role >= true;
        });

        Gate::define('all-user', function ($user) {
        return $user->role >= false || $user->role === true;
        });
    }
}