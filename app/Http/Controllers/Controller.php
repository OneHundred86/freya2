<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Lib\Output;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
