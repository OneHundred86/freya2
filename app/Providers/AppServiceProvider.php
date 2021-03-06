<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entity\User;

class AppServiceProvider extends ServiceProvider
{
    use \App\Traits\Response;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 修改root url
        $url = env('APP_URL');
        $this->forceRootUrl($url);
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
