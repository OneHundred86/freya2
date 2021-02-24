<?php
namespace App\Lib;

use GuzzleHttp\Client as Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class HttpClient
{
  // 上次执行http请求，返回的状态码
  private static $status_code = null;
  private static $response_headers;

  public function __construct(){
  }

  // get请求
  # $params :: array()   表单post数据  [$key => $val]，而非query_string
  # $params_type :: string()  'form_params' | 'multipart' | 'json'
  #         'form_params': application/x-www-form-urlencoded
  #         'multipart': multipart/form-data
  #         'json': application/json
  # $headers :: array()  [$key => $val]
  # $timeout :: float     超时秒数，0表示一直等待response结果
  # #allowRedirects :: true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function get($url, $params = [], $params_type = 'form_params', $headers = [], $timeout = 0, $allowRedirects = false){
    return self::request('GET', $url, $params, $params_type, [], $headers, $timeout, $allowRedirects);
  }

  // post请求
  # $params :: array()   表单post数据  [$key => $val]
  # $params_type :: string()  'form_params' | 'multipart' | 'json'
  #         'form_params': application/x-www-form-urlencoded
  #         'multipart': multipart/form-data
  #         'json': application/json
  # $files :: array()    表单上传文件数组 [$key => $filename]
  # $headers :: array()  [$key => $val]
  # $timeout :: float     超时秒数，0表示一直等待response结果
  # #allowRedirects :: true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function post($url, $params = [], $params_type = 'form_params',  $files = [], $headers = [], $timeout = 0, $allowRedirects = false){
    return self::request('POST', $url, $params, $params_type, $files, $headers, $timeout, $allowRedirects);
  }

  public static function postJson($url, $params = [], $headers = [], $timeout = 0){
    return self::post($url, $params, 'json', [], $headers, $timeout);
  }

  // 获取上次http请求的状态码
  public static function getStatusCode(){
    return self::$status_code;
  }

  // 获取上次http请求的所有头部列表
  public static function getResponseHeaders(){
    return self::$response_headers;
  }

  // 获取上次http请求的头部
  public static function getResponseHeader(string $header){
    if(!self::$response_headers)
      return null;

    if(array_key_exists($header, self::$response_headers))
      return self::$response_headers[$header];

    return null;
  }

  // http请求
  # $params :: array()   表单post数据  [$key => $val]
  # $params_type :: string()  'form_params' | 'multipart' | 'json'
  #         'form_params': application/x-www-form-urlencoded
  #         'multipart': multipart/form-data
  #         'json': application/json
  # $files :: array()    表单上传文件数组 [$key => $filename]
  # $headers :: array()  [$key => $val]
  # $timeout :: float     超时秒数，0表示一直等待response结果
  # $allowRedirects :: true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function request($method, $url, $params = [], $params_type = 'form_params', $files = [], $headers = [], $timeout = 0, $allowRedirects = false){
    self::$status_code = null;
    self::$response_headers = null;
    try{
      $stack = new HandlerStack();
      $stack->setHandler(new CurlHandler());
      $client = new Client(['handler' => $stack]);

      $options = [
        'headers' => $headers,
        'allow_redirects' => $allowRedirects,
        'timeout' => $timeout,
        'verify' => false,  # 临时忽略证书校验
      ];

      # 上传文件必须使用multipart类型
      if($files && $params_type != 'multipart'){
        throw new \Exception("上传文件，params_type必须使用multipart", 1);
      }

      if($params_type == 'multipart'){
        $arr = [];
        foreach($files as $k => $v){
          $arr[] = [
            'name' => $k,
            'filename' => basename($v),
            'contents' => fopen($v, 'r'),
          ];
        }

        foreach($params as $k => $v) {
          $arr[] = [
            'name' => $k,
            'contents' => $v
          ];
        }

        if($arr){
          $options['multipart'] = $arr;
        }
      }else{
        # 请求体有内容，才发送对应格式请求
        if($params){
          $options[$params_type] = $params;
        }
      }

      $response = $client->request($method, $url, $options);
      self::$status_code = $response->getStatusCode(); // 状态码不正常时，会自动抛出异常
      self::$response_headers = $response->getHeaders();
      $content = $response->getBody()->getContents();

      return $content;
    }catch(\Exception $e){
      $error = [
        'method'      => $method,
        'url'         => $url,
        'headers'     => $headers,
        'params_type' => $params_type,
        'params'      => $params,
        'files'       => $files,
        'error'       => $e->getMessage()
      ];
      \Log::error(__METHOD__, $error);
      return false;
    }
  }
}