<?php
namespace App\Lib;

/**
* 
*/
class ErrorCode
{
  // CS交互错误码(不能占用http状态码100~599)
  const ERROR = -1;
  const OK = 0;

  const VERICODE_ERROR = 1200;
  const USER_NOT_EXISTS = 1201;
  const PASSWORD_ERROR = 1202;
  const USER_BANED = 1203;
  const USER_NOT_ALLOWED = 1204;
  const PRIVATEAPI_TIME_EMPTY = 1301;
  const PRIVATEAPI_APP_EMPTY = 1302;
  const PRIVATEAPI_TOKEN_EMPTY = 1303;
  const PRIVATEAPI_APP_NOT_EXIST = 1304;
  const PRIVATEAPI_TIME_INVALID = 1305;
  const PRIVATEAPI_TOKEN_INVALID = 1306;
  const PRIVATEAPI_API_NOT_ALLOW = 1307;
  const PRIVATEAPI_IP_NOT_ALLOW = 1308;
  
  // 获取Define.php里面错误码定义对应的错误信息
  # => string()
  public static function get(int $code){
    switch ($code) {
      case self::OK:
        return 'ok';
      case self::ERROR:
        return 'error';
      case 401:
        return '请先登录';
      case 403:
        return '403 Forbidden';
      case 404:
        return '404 Not Found';
      case 405:
        return '405 Method Not Allowed';
      case 419:
        return '419 页面已失效，请刷新重试';
      case 422:
        return '参数不合法';
      case 500:
        return '500 Internal Server Error';
      case self::VERICODE_ERROR:
        return '验证码错误';
      case self::USER_NOT_EXISTS:
        return '帐号不存在或者密码错误';
      case self::USER_BANED:
        return '用户帐号已被冻结，请联系管理员';
      case self::PASSWORD_ERROR:
        return '帐号不存在或者密码错误';
      case self::USER_NOT_ALLOWED:
        return '权限不足，不允许该操作';
      case self::PRIVATEAPI_TIME_EMPTY:
        return '需要时间参数';
      case self::PRIVATEAPI_APP_EMPTY:
        return '需要app参数';
      case self::PRIVATEAPI_TOKEN_EMPTY:
        return '需要token参数';
      case self::PRIVATEAPI_APP_NOT_EXIST:
        return 'app信息不存在';
      case self::PRIVATEAPI_TIME_INVALID:
        return '时间不合法';
      case self::PRIVATEAPI_TOKEN_INVALID:
        return 'token不合法';
      case self::PRIVATEAPI_API_NOT_ALLOW:
        return 'api不允许访问';
      case self::PRIVATEAPI_IP_NOT_ALLOW:
        return 'ip不允许访问';
      
      default:
        return sprintf('未解释的错误码信息: %d', $code);
    }
  }
}