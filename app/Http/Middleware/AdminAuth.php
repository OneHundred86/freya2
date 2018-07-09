<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\LogAccess;
use App\Lib\CharacterAuth;
use App\Lib\Output;
use App\Lib\User as UserLib;
use Response;

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

        $path = $request->path();
        $auth = CharacterAuth::getAuthByRoute($path);
        if($auth){
            if(!$user->checkAuth($auth)){
                if($request->isMethod('GET'))
                    return Response::view('error.not_allowed');
                else
                    return Response::make(Output::e(ERROR_USER_NOT_ALLOWED));
            }
        }

        // access log
        $log = new LogAccess;
        $log->type = 'admin';
        $log->user_id = $user->id;
        $log->api = $path;
        $log->params = json_encode($request->all(), JSON_UNESCAPED_UNICODE);
        $log->ip = $request->ip();
        $log->save();
        
        return $next($request);
    }
}
