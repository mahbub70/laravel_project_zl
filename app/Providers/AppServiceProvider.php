<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        
        // Validation Custom Rule For Alpha, Number, Spaces & Colon - Most use in User Fullname/ Name.
        Validator::extend('alpha_num_space_colon', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9_ :]*$/', $value);

        });

        // Validation Custom Rule For Alpha, Spaces, & Coma - Most use in Product color input validation.
        Validator::extend('alpha_space_comma', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z, ]*$/', $value);

        }); 

    }

}
