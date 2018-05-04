<?php
namespace App\Lib;

use Illuminate\Support\Facades\Log as Log;
use GuzzleHttp\Client as Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class HttpClient
{
  // 上次执行http请求，返回的状态码
  private static $statusCode = null;

  public function __construct(){
  }

  // get请求
  # $headers = array()  [$key => $val]
  # #allowRedirects = true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function get($url, $headers = [], $allowRedirects = false){
    return self::request('GET', $url, [], [], $headers, $allowRedirects);
  }

  // post请求
  # $params = array()   表单post数据  [$key => $val]
  # $files = array()    表单上传文件数组 [$key => $filename]
  # $headers = array()  [$key => $val]
  # #allowRedirects = true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function post($url, $params = [], $files = [], $headers = [], $allowRedirects = false){
    return self::request('POST', $url, $params, $files, $headers, $allowRedirects);
  }

  // 获取上次执行http请求时，返回的状态码
  public static function getLastStatusCode(){
    return self::$statusCode;
  }

  // http请求
  # $params = array()   表单post数据  [$key => $val]
  # $files = array()    表单上传文件数组 [$key => $filename]
  # $headers = array()  [$key => $val]
  # #allowRedirects = true | false   是否允许30x跳转，true则返回最终跳转url执行后的返回值
  # => false | string()
  public static function request($method, $url, $params = [], $files = [], $headers = [], $allowRedirects = false){
    try{
      $stack = new HandlerStack();
      $stack->setHandler(new CurlHandler());
      $client = new Client(['handler' => $stack]);

      if(empty($files)){
        $response = $client->request($method, $url, [
          'headers' => $headers,
          'form_params' => $params,
          'allow_redirects' => $allowRedirects,
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

      self::$statusCode = $response->getStatusCode(); // 状态码不正常时，会自动抛出异常
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
      Log::error('HttpClient request:', $error);
      return false;
    }
  }

}




