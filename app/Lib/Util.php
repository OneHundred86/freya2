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

    return htmlentities($str, ENT_NOQUOTES);
  }

  public static function clean_xss($str){
    if(empty($str))
      return $str;

    $str = self::filt_script($str);
    $str = self::filt_html($str);

    return $str;
  }

}





