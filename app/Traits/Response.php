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
    return view($view, $data, $mergeData);
  }

  public function simpleView($view = null, $data = [], $statusCode = 200){
    $data['app_url'] = env('APP_URL');
    return response()->view($view, $data, $statusCode);
  }

  // 由路由名生成uri
  public function route($routeName, $params = [], $absolute = true){
    return route($routeName, $params, $absolute);
  }

  // 重定向到路由名
  public function redirect($routeName, $params = [], $absolute = true){
    $uri = $this->route($routeName, $params, $absolute);

    return redirect($uri);
  }

}

