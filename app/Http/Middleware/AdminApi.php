<?php

namespace App\Http\Middleware;

use Closure;
use App\Entity\User as UserEntity;
use App\Model\User as UserModel;
use App\Lib\ErrorCode;
use App\Lib\Session;
use App\Traits\Response as ResponseTrait;

class AdminApi
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $routeGroup)
    {
        $user = $this->getLoginUser();
        
        if($routeGroup == 'user'){
            $this->handle_user($request, $user);
        }elseif($routeGroup == 'super'){
            $this->handle_superadmin($request, $user);
        }else{
            $this->abort(sprintf('路由组未定义：%s', $routeGroup));
        }

        $this->log($request, $user, $routeGroup);

        return $next($request);
    }

    // 个人中心
    public function handle_user($request, UserEntity $user){
        // todo
    }

    // 超管
    public function handle_superadmin($request, UserEntity $user){
        if($user->group != USERGROUP_ADMIN){
            $this->abort(ErrorCode::USER_NOT_ALLOWED);
        }
    }


    # => UserEntity
    private function getLoginUser(){
        $user_id = Session::getLoginUserID();
        if(!$user_id){
            $this->abort(401);
        }

        $user = UserModel::find($user_id);
        if(!$user){
            Session::flush();
            $this->abort(401);
        }

        if($user->ban != USER_UNBAN){
            $this->abort(\ErrorCode::USER_BANED);
        }

        $ue = app()->make(UserEntity::class);
        $ue->setModel($user);

        return $ue;
    }

    private function log($request, UserEntity $user, $routeGroup){
        // access log
        \Log::channel('web-access')->debug(__METHOD__, [
            'user_id' => $user->id,
            'api' => $request->path(),
            'ip' => $request->ip(),
            'params' => substr(json_encode($request->all(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), 0, 65535),
        ]);
    }
}
