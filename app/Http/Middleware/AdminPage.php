<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\Response as ResponseTrait;
use App\Lib\Session;

class AdminPage
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Session::getLoginUserID();
        if(!$user_id){
            return $this->redirect2RouteName('adminLogin');
        }
        
        return $next($request);
    }
}
