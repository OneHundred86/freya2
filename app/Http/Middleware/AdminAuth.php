<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib\Session;
use App\Lib\User;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $user_id = Session::getLoginUserID();
        // if(empty($user_id)){
        //     return redirect()->route('adminLogin');
        //     // die();
        // }
        $user = User::getLoginUser();
        if(empty($user)){
            return redirect()->route('adminLogin');
        }
        
        return $next($request);
    }
}
