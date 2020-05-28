<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Extensions\EloquentLdapUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('root-actions', 'App\Policies\CorePolicy@root_actions');
        Gate::define('admin-actions', 'App\Policies\CorePolicy@admin_actions');
        Gate::define('delete-users', 'App\Policies\CorePolicy@delete_users');
        Gate::define('delete-roles', 'App\Policies\CorePolicy@delete_roles');
        Gate::define('edit-roles', 'App\Policies\CorePolicy@edit_roles');
        
        Auth::provider('eloquentldap', function ($app, array $config) {
            return new EloquentLdapUserProvider(app('hash'),$config['model']);
        });   
    }
}
