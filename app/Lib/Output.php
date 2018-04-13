<?php
namespace App\Lib;

/**
* 
*/
class Output
{
  
  public function __construct(){
  }

  // 自定义借口：输出json
  # code : int|mix  0成功，其他数字表示错误
  # data : mix
  public static function o($code = ERROR_OK, $data = "ok"){
    if(!is_integer($code)){
      $data = $code;
      $code = ERROR_OK;
    }

    return [
      'code' => $code,
      'data' => $data,
    ];
  }

  public static function e($code = -1, $data = "error"){
    if(!is_integer($code)){
      $data = $code;
      $code = -1;
    }

    return self::o($code, $data);
  }

}





