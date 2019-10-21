<?php
namespace App\Traits;

use App\Lib\ErrorCode;

trait Response{
  // 格式化数据返回格式
  protected function format($code, $data = null){
    if(!is_integer($code)){
      $data = $code;
      $code = ErrorCode::OK;
    }
    if(empty($data)){
      $data = ErrorCode::get($code);
    }

    return [
      'code' => $code,
      'data' => $data,
    ];
  }

  // 自定义借口：输出json
  # code : int|mix  0成功，其他数字表示错误
  # data : mix
  public function o($code = ErrorCode::OK, $data = null){
    return response()->make(json_encode($this->format($code, $data), JSON_UNESCAPED_UNICODE), 200, ['Content-Type' => 'application/json']);
  }

  public function e($code = ErrorCode::ERROR, $data = null){
    if(!is_integer($code)){
      $data = $code;
      $code = ErrorCode::ERROR;
    }

    return $this->o($code, $data);
  }

  # $msg : int|string
  public function errorPage($msg = ErrorCode::ERROR, $errorView = 'error', $statusCode = 200){
    if(is_integer($msg))
      $msg = ErrorCode::get($msg);

    return $this->simpleView("error/$errorView", ['error_msg' => $msg], $statusCode);
  }


  public function view($view = null, $data = [], $mergeData = []) {
    $data['app_url'] = env('APP_URL');
    $data['version'] = env('VERSION');
    if(empty($data['title']))
      $data['title'] = env('APP_TITLE', 'Freya2.0');

    return view($view, $data, $mergeData);
  }

  public function simpleView($view = null, $data = [], $statusCode = 200){
    $data['app_url'] = env('APP_URL');
    $data['version'] = env('VERSION');
    if(empty($data['title']))
      $data['title'] = env('APP_TITLE', 'Freya2.0');
    
    return response()->view($view, $data, $statusCode);
  }

  public function redirect($routeName, $params = [], $absolute = true){
    $uri = route($routeName, $params, $absolute);
    return redirect($uri);
  }

  public function forceRootUrl($url){
    \URL::forceRootUrl($url);
    \URL::forceScheme(substr($url, 0, strpos($url, ':')));
  }

}

