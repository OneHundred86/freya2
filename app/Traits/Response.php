<?php
namespace App\Traits;

use App\Lib\Output;

trait Response{
  // 自定义借口：输出json
  # code : int|mix  0成功，其他数字表示错误
  # data : mix
  public function o($code = ERROR_OK, $data = ""){
    return Output::o($code, $data);
  }

  public function e($code = ERROR_ERR, $data = ""){
    return Output::e($code, $data);
  }


  public function view($view = null, $data = [], $mergeData = []) {
    $data['app_url'] = env('APP_URL');
    $data['version'] = env('VERSION');
    if (!isset($data['title'])) {
      $data['title'] = 'Freya2.0';
    }
    return view($view, $data, $mergeData);
  }
}