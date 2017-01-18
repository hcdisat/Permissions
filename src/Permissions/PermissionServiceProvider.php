<?php namespace CVA\Permissions;

use CVA\Permissions\Contracts\IPermissable;
use CVA\Permissions\Contracts\IRoleable;
use CVA\Permissions\Models\Permission;
use CVA\Permissions\Models\Role;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // publishes migrations
        $this->publishes([
            __DIR__ . '/Database/migrations/' => $this->app->databasePath().'/migrations'
        ], 'migrations');

        // model factories
        $this->publishes([
            __DIR__ . '/Database/factories/' => $this->app->databasePath().'/factories'
        ], 'factory');

        $this->publishes([
            __DIR__ . '/config/permissions.php' => config_path('permissions.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Models
         */
        $this->app->make(Permission::class);
        $this->app->make(Role::class);

        $this->app->bind(
            IRoleable::class,
            config('permissions.user')
        );

        $this->app->bind(
            IPermissable::class,
            config('permissions.user')
        );
    }
}
