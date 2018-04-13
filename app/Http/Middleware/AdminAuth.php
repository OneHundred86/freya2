<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\LogAccess;
use App\Lib\User as UserLib;

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
        $user = UserLib::getLoginUser();
        if(empty($user)){
            return redirect()->route('adminLogin');
            // die();
        }

        // access log
        $log = new LogAccess;
        $log->type = 'admin';
        $log->user_id = $user->id;
        $log->api = $request->path();
        $log->params = json_encode($request->all(), JSON_UNESCAPED_UNICODE);
        $log->ip = $request->ip();
        $log->save();
        
        return $next($request);
    }
}
