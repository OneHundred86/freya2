<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib\Session;
use App\Model\LogAccess;
use App\Model\User as UserModel;
use App\Entity\User as UserEntity;

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
        $user_id = Session::getLoginUserID();
        if(empty($user_id)){
            return redirect()->route('adminLogin');
            // die();
        }

        $user = resolve(UserEntity::class);
        $user->setModel(UserModel::find($user_id));

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
