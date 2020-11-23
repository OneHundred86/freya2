<?php
namespace App\Traits;

use App\Lib\ErrorCode;
use App\Exceptions\ErrorCodeException;

trait Response{
  // 自定义借口：输出json
  # errcode : int|mix  0成功，其他数字表示错误
  # data : mix
  public function o($data = null){
    $errcode = ErrorCode::OK;
    $errmessage = ErrorCode::get($errcode);

    $arr = compact('errcode', 'errmessage', 'data');

    return response()->make(json_encode($arr, JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
  }

  public function e($errcode = ErrorCode::ERROR, $errmessage = null, $data = null){
    if(!is_integer($errcode)){
      $errmessage = $errcode;
      $errcode = ErrorCode::ERROR;
    }
    if(empty($errmessage)){
      $errmessage = ErrorCode::get($errcode);
    }

    $arr = compact('errcode', 'errmessage', 'data');

    return response()->make(json_encode($arr, JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
  }

  # $msg : int|string
  public function errorPage($msg = ErrorCode::ERROR, $statusCode = 200){
    if(is_integer($msg))
      $msg = ErrorCode::get($msg);

    return response()->view("error/error", compact('msg'), $statusCode);
  }

  public function abort($errcode = ErrorCode::ERROR, $errmessage = null, $data = null){
    throw new ErrorCodeException($errcode, $errmessage, $data);
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

