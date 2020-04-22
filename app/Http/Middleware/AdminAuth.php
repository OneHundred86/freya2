<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\LogAccess;
use App\Lib\CharacterAuth;
use App\Lib\User as UserLib;
use App\Traits\Response as ResponseTrait;

class AdminAuth
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
        $isGetMethod = $request->isMethod('GET');
        $path = $request->path();

        $user_id = Session::getLoginUserID();
        if(!$user_id){
            if($isGetMethod)
                return $this->redirect('adminLogin');
            else
                return $this->e(401);
        }

        $user = UserModel::find($user_id);
        if(!$user){
            Session::flush();
            if($isGetMethod)
                return $this->redirect('adminLogin');
            else
                return $this->e(401);
        }


        if($user->ban != USER_UNBAN){
            if($isGetMethod)
                return $this->errorPage(\ErrorCode::USER_BANED);
            else
                return $this->e(\ErrorCode::USER_BANED);
        }

        $ue = app()->make(UserEntity::class);
        $ue->setModel($user);

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
