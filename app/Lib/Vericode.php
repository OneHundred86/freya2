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
  public static function checkImageVericode($code, $invalid_code = true){
    $sessionCode = Session::getImageVericode();

    if($invalid_code) # 图片验证码，建议无论对错都单次有效
      self::invalidImageVericode();

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

