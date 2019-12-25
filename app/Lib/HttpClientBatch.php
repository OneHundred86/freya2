<?php
namespace App\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/*
异步批量http请求

Request ::  [
                'method' => null|'GET'|'POST'|...,   # 请求方法头，默认为'POST'
                'uri' => url(),             # 请求uri
                'params' => null | array(), # 请求body参数
                'headers' => null|array(),  # 请求头
                'key' => null|string(),     # key，返回的结果的时候，响应结果填充到ResponseArr对应的key的值；null则会赋值为添加Request的对应索引
            ]
*/

class HttpClientBatch{
    protected $requests;

    # $requests :: array(Request)
    public function __construct($requests = []){
        foreach($requests as $request){
            $this->checkRequestFormat($request);
        }

        $this->requests = $requests;
    }

    // 添加异步请求
    # request :: Request
    public function add($request){
        $this->checkRequestFormat($request);
        $this->requests[] = $request;
    }

    # $request :: Request
    protected function checkRequestFormat(array &$request){
        if(empty('uri'))
            throw new \Exception(sprintf("uri not defined"), 1);

        # 默认为POST
        if(empty($request['method']))
            $request['method'] = 'POST';
        else
            $request['method'] = strtoupper($request['method']);

        if(!isset($request['key']))
            $request['key'] = count($this->requests);

        return true;
    }

    /*
    执行批量请求并获取结果
    # => ResponseArr :: array(Response)
    #    Response :: false # 表示失败
    #             :: [
    #                   'status_code' => 200,           # 响应http状态吗
    #                   'response_headers' => array(),  # 响应头部
    #                   'content' => '...',             # 响应body内容
    #                ]
    */
    public function request(){
        $responses = [];
        $client = new Client();
        // dd($this->requests);

        $requests = function () {
            foreach($this->requests as $request){
                $method = $request['method'];
                $uri = $request['uri'];
                $headers = empty($request['headers']) ? [] : $request['headers'];
                $params = empty($request['params']) ? null : $request['params'];

                $body = $this->parseHeaderAndGenBody($method, $headers, $params);

                // \Log::debug(__METHOD__, compact('headers', 'params', 'body'));
                yield new Request($method, $uri, $headers, $body);
            }
        };

        $pool = new Pool($client, $requests(), [
            'concurrency' => count($this->requests),
            'fulfilled' => function ($response, $index) use(&$responses) {
                $key = $this->requests[$index]['key'];
                $responses[$key] = [
                    'status_code' => $response->getStatusCode(),
                    'response_headers' => $response->getHeaders(),
                    'content' => $response->getBody()->getContents(),
                ];
            },
            'rejected' => function ($exception, $index) use(&$responses) {
                $request = $this->requests[$index];
                $key = $request['key'];
                if($exception instanceof ClientException || $exception instanceof ServerException){
                    $response = $exception->getResponse();
                    $responses[$key] = [
                        'status_code' => $response->getStatusCode(),
                        'response_headers' => $response->getHeaders(),
                        'content' => $response->getBody()->getContents(),
                    ];
                    return;
                }

                $responses[$key] = false;
                // dd($exception);
                \Log::error('HttpClientBatch::request failed', ['reason' => $exception->getMessage(), 'request' => $request]);
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        return $responses;
    }

    # => string|null|resource
    protected function parseHeaderAndGenBody($method, array &$headers, array $params){
        if($method == 'GET')
            return null;

        # 非GET请求，Content-Type默认为'application/x-www-form-urlencoded'
        if(empty($headers['Content-Type']))
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';

        switch($headers['Content-Type']){
            case 'application/json':
                return json_encode($params);
            default:
                return http_build_query($params);
        }
    }
}