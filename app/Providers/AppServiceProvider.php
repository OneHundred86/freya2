<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
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

        # debug模式，打印sql语句
        !env('APP_DEBUG') ?: \Event::listen(QueryExecuted::class, function(QueryExecuted $queryExecuted) {
            $queryExecuted->bindings = collect($queryExecuted->bindings)->map(function (&$arg) {
                if (is_string($arg)) {
                    $arg = "'" . $arg . "'";
                }

                return $arg;
            });

            \Log::info(sprintf(str_replace('?', '%s', str_replace('%', '%%', $queryExecuted->sql)), ...$queryExecuted->bindings));
        });
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
