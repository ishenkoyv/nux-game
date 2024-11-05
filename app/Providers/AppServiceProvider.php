<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Auth\SessionGuard as AppSessionGuard;

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
    public function boot(Router $router): void
    {
        Auth::extend('appsession', function ($app, $name, array $config) {
            return new AppSessionGuard('appsession', Auth::createUserProvider($config['provider']), $app->make('session.store'), $app->make('request'));
        });
        $router->aliasMiddleware('link_is_active', '\App\Http\Middleware\LinkIsActive::class');
    }
}
