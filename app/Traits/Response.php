<?php
namespace App\Traits;

use App\Lib\ErrorCode;
use App\Exceptions\ErrorCodeException;

trait Response{
  // 自定义借口：输出json
  # code : int|mix  0成功，其他数字表示错误
  # data : mix
  public function o($data = null){
    $code = ErrorCode::OK;
    $message = ErrorCode::get($code);

    $arr = compact('code', 'message', 'data');

    return response()->make(json_encode($arr, JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
  }

  public function e($code = ErrorCode::ERROR, $message = null, $data = null){
    if(!is_integer($code)){
      $message = $code;
      $code = ErrorCode::ERROR;
    }
    if(empty($message)){
      $message = ErrorCode::get($code);
    }

    $arr = compact('code', 'message', 'data');

    return response()->make(json_encode($arr, JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
  }

  # $msg : int|string
  public function errorPage($msg = ErrorCode::ERROR, $statusCode = 200){
    if(is_integer($msg))
      $msg = ErrorCode::get($msg);

    return response()->view("error/error", compact('msg'), $statusCode);
  }

  public function abort($code = ErrorCode::ERROR, $message = null, $data = null){
    throw new ErrorCodeException($code, $message, $data);
  }

  public function redirect2RouteName($routeName, $params = [], $absolute = true){
    $uri = route($routeName, $params, $absolute);
    return redirect($uri);
  }

  public function forceRootUrl($url){
    \URL::forceRootUrl($url);
    \URL::forceScheme(substr($url, 0, strpos($url, ':')));
  }

}

