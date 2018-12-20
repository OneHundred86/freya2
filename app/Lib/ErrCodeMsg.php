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
        return 'ok';
      case ERROR_ERR:
        return 'error';
      case 403:
        return '403 forbidden';
      case 404:
        return '404 页面不存在';
      case 405:
        return '405 method not allowed';
      case 419:
        return '419 token过期，请刷新重试';
      case ERROR_VERICODE_ERROR:
        return '验证码错误';
      case ERROR_USER_NOT_EXISTS:
        return '帐号不存在或者密码错误';
      case ERROR_USER_BANED:
        return '用户帐号已被冻结，请联系管理员';
      case ERROR_PASSWORD_ERROR:
        return '帐号不存在或者密码错误';
      case ERROR_USER_NOT_ALLOWED:
        return '权限不足，不允许该操作';
      case ERROR_PRIVATEAPI_TIME_EMPTY:
        return '需要时间参数';
      case ERROR_PRIVATEAPI_APP_EMPTY:
        return '需要app参数';
      case ERROR_PRIVATEAPI_TOKEN_EMPTY:
        return '需要token参数';
      case ERROR_PRIVATEAPI_APP_NOT_EXIST:
        return 'app信息不存在';
      case ERROR_PRIVATEAPI_TIME_INVALID:
        return '时间不合法';
      case ERROR_PRIVATEAPI_TOKEN_INVALID:
        return 'token不合法';
      case ERROR_PRIVATEAPI_API_NOT_ALLOW:
        return 'api不允许访问';
      
      default:
        return sprintf('未解释的错误码信息: %d', $code);
    }
  }
}