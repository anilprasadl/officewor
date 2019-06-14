<?php

namespace App\Providers;
use Carbon\Carbon;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('email_domain', function($attribute, $value, $parameters, $validator) {
        	$allowedEmailDomains = ['jmangroup.com', 'ig.com'];
        	return in_array( explode('@', $parameters[0])[1] , $allowedEmailDomains);
        });
    }
}
