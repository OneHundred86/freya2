<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\Response as ResponseTrait;
use App\Model\PrivateApi as PrivateApiModel;
use App\Model\LogPrivateApi as LogPrivateApiModel;

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

        // access log
        \Log::channel('private-api-access')->debug(__METHOD__, [
            'app' => $request->app,
            'api' => $request->path(),
            'ip' => $request->ip(),
            'params' => substr(json_encode($request->all(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), 0, 65535),
        ]);
        
        return $next($request);
    }

    public function checkToken($request){
        $time = $request->time;
        $app = $request->app;
        $token = $request->token;

        if(empty($time))
            return \ErrorCode::PRIVATEAPI_TIME_EMPTY;
        if(empty($app))
            return \ErrorCode::PRIVATEAPI_APP_EMPTY;
        if(empty($token))
            return \ErrorCode::PRIVATEAPI_TOKEN_EMPTY;

        $now = time();
        # 时间不能相差超过5分钟
        if(abs($now - $time) > 300)
            return \ErrorCode::PRIVATEAPI_TIME_INVALID;

        $m = PrivateApiModel::find($app);
        if(!$m)
            return \ErrorCode::PRIVATEAPI_APP_NOT_EXIST;

        $api = $request->path();
        if(!$m->isApiExist($api))
            return \ErrorCode::PRIVATEAPI_API_NOT_ALLOW;

        $ip = $request->ip();
        if(!$m->isIpAllow($ip))
            return \ErrorCode::PRIVATEAPI_IP_NOT_ALLOW;

        # 客户端得遵照这个格式生成token
        $tokenValid = md5($app . $time . $m->ticket);
        if($token != $tokenValid)
            return \ErrorCode::PRIVATEAPI_TOKEN_INVALID;

        return true;
    }
}
