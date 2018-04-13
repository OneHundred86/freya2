<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entity\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // echo "boot";
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // echo "register";
        $this->app->singleton(User::class, function ($app) {
            return new User;
        });
    }
}
