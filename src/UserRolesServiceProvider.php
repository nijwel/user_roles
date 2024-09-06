<?php

namespace Nijwel\UserRoles;

use Illuminate\Support\ServiceProvider;
use Nijwel\UserRoles\Services\UserRoleService;

class UserRolesServiceProvider extends ServiceProvider
{
    public function boot()
    {

        // Register the middleware
        $this->app['router']->aliasMiddleware('role', \Nijwel\UserRoles\Middleware\CheckUserRole::class);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load routes
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'roles');

        // Publish configuration, migrations, etc.
        $this->publishes([
            __DIR__ . '/../config/userroles.php' => config_path('userroles.php'),
        ], 'config');
    }

    public function register()
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/userroles.php',
            'tag'
        );

        // Register the service class
        $this->app->singleton(UserRoleService::class, function ($app) {
            return new UserRoleService();
        });

        $this->loadHelpers();
    }

    protected function loadHelpers()
    {
        $helpers = __DIR__ . '/Helpers/helpers.php';

        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }
}
