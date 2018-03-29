<?php
namespace App\Lib;

/**
* 工具类函数集合
*/
class Util
{
  
  public function __construct(){
  }

  // app标识的tag
  # => string()
  public static function appTag($name){
    return env('APP_NAME') . '_' . $name;
  }

  public static function cookieTag($name){
    return self::appTag($name . '@cookie');
  }

}





