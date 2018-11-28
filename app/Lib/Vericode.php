<?php
namespace App\Lib;

use Gregwar\Captcha\CaptchaBuilder;
use App\Lib\Session;

class Vericode
{
  // 生成图形验证码
  # => response()
  public static function genImageVericode(){
    $builder = new CaptchaBuilder;
    $builder->build();
    Session::setImageVericode($builder->getPhrase());
    return response($builder->output())->header('Content-Type', 'image/JPEG');
  }

  // 校对图形验证码的正确性
  # => true | false
  public static function checkImageVericode($code){
    $sessionCode = Session::getImageVericode();
    if(empty($sessionCode))
      return false;
    elseif(strtolower($sessionCode) != strtolower($code))
      return false;

    return true;
  }

  public static function invalidImageVericode(){
    Session::eraseImageVericode();
  }
  
}

