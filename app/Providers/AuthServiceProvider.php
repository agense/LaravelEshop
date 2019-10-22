<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

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

        //Define SuperAdmin Gate
        Gate::define('isSuperadmin', function($user){
           return $user->role === "superadmin";
        });

        //Define Admin Gate
        Gate::define('isAdmin', function($user){
            if(Auth::user()->role === "superadmin" || Auth::user()->role === "admin"){
                return true;
            }
            return false;
        });
    }
}
