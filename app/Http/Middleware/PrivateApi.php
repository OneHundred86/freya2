<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\Response as ResponseTrait;
use App\Model\PrivateApi as PrivateApiModel;

class PrivateApi
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
        $code = $this->checkToken($request);
        if($code !== true){
            return $this->e($code);;
        }
        
        return $next($request);
    }

    public function checkToken($request){
        $time = $request->time;
        $app = $request->app;
        $token = $request->token;

        if(empty($time))
            return ERROR_PRIVATEAPI_TIME_EMPTY;
        if(empty($app))
            return ERROR_PRIVATEAPI_APP_EMPTY;
        if(empty($token))
            return ERROR_PRIVATEAPI_TOKEN_EMPTY;

        $now = time();
        # 时间不能相差超过5分钟
        if(abs($now - $time) > 300)
            return ERROR_PRIVATEAPI_TIME_INVALID;

        $m = PrivateApiModel::find($app);
        if(!$m)
            return ERROR_PRIVATEAPI_APP_NOT_EXIST;

        $api = $request->path();
        if(!$m->is_api_exist($api))
            return ERROR_PRIVATEAPI_API_NOT_ALLOW;

        # 客户端得遵照这个格式生成token
        $tokenValid = md5($app . $time . $m->ticket);
        if($token != $tokenValid)
            return ERROR_PRIVATEAPI_TOKEN_INVALID;

        return true;
    }
}
