<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use \Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Session\TokenMismatchException;
use App\Traits\Response as ResponseTrait;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ErrorCodeException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // dd($exception);
        $isGetMethod = $request->isMethod('GET');

        // 自定义错误码异常捕捉
        if($exception instanceof ErrorCodeException){
            $code = $exception->getCode();
            $msg = $exception->getMessage();
            $data = $exception->getData();

            if($isGetMethod){
                $statusCode = $code >= 100 && $code <= 599 ? $code : 200;
                return $this->errorPage($msg ?: $code, $statusCode);
            }else{
                return $this->e($code, $msg, $data);
            }
        }

        if($exception instanceof HttpException){
            $statusCode = $exception->getStatusCode();
            $msg = $exception->getMessage();

            // 自定义处理的异常http状态码页面
            if($isGetMethod)
                return $this->errorPage($msg ?: $statusCode, $statusCode);
            else
                return $this->e($statusCode, $msg);
        }

        if($exception instanceof ValidationException){
            $statusCode = $exception->status; // 422

            if($isGetMethod){
                return $this->errorPage($statusCode, $statusCode);
            }else{
                return $this->e($statusCode, '', $exception->errors());
            }
        }

        if($exception instanceof TokenMismatchException){
            // 自定义处理的异常http状态码页面
            $statusCode = 419;
            return $this->e($statusCode);
        }

        if($exception instanceof FatalErrorException && !env('APP_DEBUG')){
            // 自定义处理的异常http状态码页面
            $statusCode = 500;
            if($isGetMethod)
                return $this->errorPage($statusCode, $statusCode);
            else
                return $this->e($statusCode);
        }

        return parent::render($request, $exception);
    }
}
