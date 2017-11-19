<?php

namespace App\Providers;

use App\Model\admin\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissions = \App\Model\admin\AdminPermission::with('roles')->get();
        foreach ($permissions as $permission) {
            Gate::define($permission->name, function(Admin $user) use($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}
