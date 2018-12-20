<?php
namespace App\Traits;

use App\Lib\Output;
use App\Lib\ErrCodeMsg;

trait Response{
  // 自定义借口：输出json
  # code : int|mix  0成功，其他数字表示错误
  # data : mix
  public function o($code = ERROR_OK, $data = ""){
    return response()->make(Output::o($code, $data));
  }

  public function e($code = ERROR_ERR, $data = ""){
    return response()->make(Output::e($code, $data));
  }

  # $msg : int|string
  public function errorPage($msg = ERROR_ERR, $errorView = 'error', $statusCode = 200){
    if(is_integer($msg))
      $msg = ErrCodeMsg::get($msg);

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

  // 由路由名生成uri
  public function route($routeName, $params = [], $absolute = true){
    $uri = route($routeName, $params, false);

    if($absolute){
      $uri = env('APP_URL') . $uri;
    }

    return $uri;
  }

  // 重定向到路由名
  public function redirect($routeName, $params = [], $absolute = true){
    $uri = $this->route($routeName, $params, $absolute);

    return redirect($uri);
  }

  // 重定向到路由路径
  public function redirectPath($path, $params = [], $absolute = true){
    $uri = Util::genUrl($path, $params);

    if($absolute){
      $uri = env('APP_URL') . $uri;
    }

    return redirect($uri);
  }

  // 重定向到url
  public function redirectUrl($url, $params = []){
    $url = Util::genUrl($url, $params);

    return redirect($url);
  }

}

