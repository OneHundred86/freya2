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

  public static function genUrl($url, array $params = []){
    if(!$params)
      return $url;
    
    if(strpos($url, '?') === false){
      $url .= '?';
    }else{
      $url .= '&';
    }

    $url .= http_build_query($params);

    return $url;
  }

  // 获取url的域名
  # => string()
  public static function getDomain($url) {
    $s = explode('://', $url);
    if (count($s) < 2) {
      $r = $s[0];
    }else{
      $r = $s[1];
    }

    $t = explode('/', $r);
    return $t[0];
  }

  public static function filt_script($str){
    if(!$str)
      return $str;

    // return str_ireplace(
    //   ['<script', '<style', '<link', '</script', '</style', '<img', '<svg',
    //   '<iframe', '<form', '<input', '<audio', '<video', '<source', '</source',
    //   '<select', '<keygen', '<textarea', '</textarea'], 
    //   ['<noscript', '<nostyle', '<nolink', '</noscript', '</nostyle', '<noimg', '<nosvg', 
    //   '<noiframe', '<noform', '<noinput', '<noaudio', '<novideo', '<nosource', '</source',
    //   '<noselect', '<nokeygen', '<notextarea', '</notextarea'], $str);
    
    return str_ireplace(['<', '>', "'", '"'], ['《', '》', '’', '”'], $str);
  }

  public static function filt_html($str){
    if(!$str)
      return $str;

    // return htmlentities($str, ENT_NOQUOTES);
    return htmlspecialchars($str, ENT_NOQUOTES);
  }

  public static function clean_xss($str){
    if(empty($str))
      return $str;

    $str = self::filt_script($str);
    $str = self::filt_html($str);

    return $str;
  }

  // 递归获取文件夹的所有文件
  # $path :: 文件夹路径
  # $depth :: 遍历深度
  # => array()
  public static function listFiles(string $path, ?int $depth = null){
    $arr = [];

    if($depth !== null){
      if($depth <= 0){
        return $arr;
      }

      $depth--;
    }

    foreach(scandir($path) as $v){
      if($v === '.' || $v === '..'){
        continue;
      }

      $file = $path . "/$v";
      if(is_dir($file)){
        $arr = array_merge($arr, self::listFiles($file, $depth));
      }else{
        $arr[] = $file;
      }
    }

    return $arr;
  }

}





