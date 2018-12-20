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
        // 修改根目录url
        app('url')->forceRootUrl(env('APP_URL'));
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
