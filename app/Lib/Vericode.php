<?php
namespace App\Lib;

class Vericode
{
  // 生成图形验证码
  public static function genImageVericode(){
    $code = self::gen_code();
    Session::setImageVericode($code);
    return self::gen_simple_image($code);
  }

  // 校对图形验证码的正确性
  # => true | false
  public static function checkImageVericode($code){
    $sessionCode = Session::getImageVericode();
    // dd($code, $sessionCode);
    if(empty($sessionCode))
      return false;
    elseif(strtoupper($sessionCode) != strtoupper($code))
      return false;

    return true;
  }

  public static function invalidImageVericode(){
    Session::eraseImageVericode();
  }
  
  ##########################################################
  # 生成随机数
  private static function gen_code($len = 4){
      $s = '';
      for($i = 0; $i < $len; $i ++){
          $s .= self::gen_char();
      }
      return $s;
  }

  private static function gen_char(){
      $cs = ['1','2','3','4','5','6','7','8','9','Q','W','E','R','T','Y','U','I','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'];
      return $cs[rand(0, 33)];
  }
  
  # 生成图片并显示
  private static function gen_image($str, $w = 80, $h = 30, $r = 255, $g = 255, $b = 255){
      $img = imagecreatetruecolor($w, $h);
      imagefill($img, 0, 0, imageColorAllocate($img, $r, $g, $b));
      $s = ''.$str;
      for($i = 0; $i < 4; $i ++){
          $fc = imageColorAllocate($img, rand(0, 150), rand(0, 150), rand(0, 150));
          imageline($img, 0, rand(0, $h), $w, rand(0, $h), $fc); 
          imageString($img, 5, $i * $w/4 + rand(0, $w/8), rand(1, $h/2), $s[$i], $fc);
      }
      header("Content-type: image/JPEG");
      imagejpeg($img);
      imagedestroy($img);
  }

  private static function gen_simple_image($str){
        $w = 45;
        $h = 23;
        $img = imagecreatetruecolor($w, $h);
        imagefill($img, 0, 0, imageColorAllocate($img, 189, 229, 255));
        $s = ''.$str;
        for($i = 0; $i < 4; $i ++){
            $fc = imageColorAllocate($img, 38, 76, 102);
            imageString($img, 11, $i * $w/4 + rand(0, $w/8), rand(1, $h/2), $s[$i], $fc);
        }
        // header("Content-type: image/JPEG");
        imagejpeg($img);
        imagedestroy($img);
        return response('')->header('Content-Type', 'image/JPEG');
    }
}