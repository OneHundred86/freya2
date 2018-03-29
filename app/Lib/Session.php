<?php
namespace App\Lib;

/*
说明：把所有的关于session的存取函数都统一写到这里来，为了统一管理，防止session key重复。
*/

class Session
{
  #################### 公共借口函数 #######################
  static public function get($key, $default = null){
    return session()->get($key, $default);
  }

  static public function put($key, $val){
    session()->put([$key => $val]);
  }

  static public function pull($key, $default = null){
    return session()->pull($key, $default);
  }

  static public function forget($key){
    session()->forget($key);
  }

  ################### 当前登录用户id ########################
  static public function getLoginUserID(){
    return self::get('uid');
  }

  static public function setLoginUserID($userID){
    self::put('uid', $userID);
  }

  static public function eraseLoginUserID(){
    self::forget('uid');
  }

  ################### 图形验证码 ########################
  static public function getImageVericode(){
    return self::get('image_vericode');
  }

  static public function setImageVericode($code){
    self::put('image_vericode', $code);
  }

  static public function eraseImageVericode(){
    self::forget('image_vericode');
  }

  ################### todo ########################

}