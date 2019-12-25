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
  # $headers :: array()  [$key => $val]
  # $timeout :: float     超时秒数，0表示一直等待response结果
  # #allowRedirects :: true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function get($url, $headers = [], $timeout = 0, $allowRedirects = false){
    return self::request('GET', $url, [], [], $headers, $timeout, $allowRedirects);
  }

  // post请求
  # $params :: array()   表单post数据  [$key => $val]
  # $files :: array()    表单上传文件数组 [$key => $filename]
  # $headers :: array()  [$key => $val]
  # $timeout :: float     超时秒数，0表示一直等待response结果
  # #allowRedirects :: true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function post($url, $params = [], $files = [], $headers = [], $timeout = 0, $allowRedirects = false){
    return self::request('POST', $url, $params, $files, $headers, $timeout, $allowRedirects);
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
  # $files :: array()    表单上传文件数组 [$key => $filename]
  # $headers :: array()  [$key => $val]
  # $timeout :: float     超时秒数，0表示一直等待response结果
  # $allowRedirects :: true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function request($method, $url, $params = [], $files = [], $headers = [], $timeout = 0, $allowRedirects = false){
    self::$status_code = null;
    self::$response_headers = null;
    try{
      $stack = new HandlerStack();
      $stack->setHandler(new CurlHandler());
      $client = new Client(['handler' => $stack]);

      # 默认是表单提交
      if(empty($files)){
        if(empty($headers['Content-Type'])){
          $bkey = "form_params";
        }elseif($headers['Content-Type'] == 'application/json'){
          $bkey = "json";
        }else{
          $bkey = "form_params";
        }

        $response = $client->request($method, $url, [
          'headers' => $headers,
          $bkey => $params,
          'allow_redirects' => $allowRedirects,
          'timeout' => $timeout,
        ]);
      }else{  // 上传文件
        $arr = [];
        foreach($files as $k => $v){
          $arr[] = [
            'name' => $k,
            'contents' => fopen($v, 'r'),
          ];
        }
        foreach($params as $k => $v) {
          $arr[] = [
            'name' => $k,
            'contents' => $v
          ];
        }

        $response = $client->request($method, $url, [
          'headers' => $headers,
          'multipart' => $arr,
        ]);
      }

      self::$status_code = $response->getStatusCode(); // 状态码不正常时，会自动抛出异常
      self::$response_headers = $response->getHeaders();
      $content = $response->getBody()->getContents();

      return $content;
    }catch(\Exception $e){
      $error = [
        'method'      => $method,
        'url'         => $url,
        'headers'     => $headers,
        'params'      => $params,
        'files'       => $files,
        'error'       => $e->getMessage()
      ];
      \Log::error(__METHOD__, $error);
      return false;
    }
  }
}