<?php
namespace App\Lib;

/**
* 
*/
class ErrCodeMsg
{
  
  // 获取Define.php里面错误码定义对应的错误信息
  # => string()
  public static function get(int $code){
    switch ($code) {
      case ERROR_OK:
        $msg = "ok";
        break;
      case ERROR_ERR:
        $msg = "error";
        break;
      case ERROR_VERICODE_ERROR:
        $msg = "验证码错误";
        break;
      case ERROR_USER_NOT_EXISTS:
        $msg = "帐号不存在或者密码错误";
        break;
      case ERROR_USER_BANED:
        $msg = "用户帐号已被冻结，请联系管理员";
        break;
      case ERROR_PASSWORD_ERROR:
        $msg = "帐号不存在或者密码错误";
        break;
      
      default:
        $msg = sprintf("未解释的错误码信息: %d", $code);
        break;
    }

    return $msg;
  }
}