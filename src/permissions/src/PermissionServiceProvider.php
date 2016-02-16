<?php namespace ITeam\Permissions;

use ITeam\Permissions\Models\Credential;
use ITeam\Permissions\Models\Network;
use ITeam\Permissions\Models\Permission;
use ITeam\Permissions\Models\Person;
use ITeam\Permissions\Models\PersonType;
use ITeam\Permissions\Models\Role;
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
            __DIR__ . '/database/migrations/' => $this->app->databasePath().'/migrations'
        ], 'migrations');

        // model factories
        $this->publishes([
            __DIR__ . '/database/factories/' => $this->app->databasePath().'/factories'
        ], 'factory');
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
        $this->app->make(Credential::class);
        $this->app->make(Network::class);
        $this->app->make(Permission::class);
        $this->app->make(Person::class);
        $this->app->make(PersonType::class);
        $this->app->make(Role::class);
    }
}
