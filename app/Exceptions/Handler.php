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
        //
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
        if($exception instanceof HttpException){
            $statusCode = $exception->getStatusCode();
            // 自定义处理的异常http状态码页面
            if($isGetMethod)
                return $this->errorPage($statusCode, 'error', $statusCode);
            else
                return $this->e($statusCode);
        }

        if($exception instanceof TokenMismatchException){
            // 自定义处理的异常http状态码页面
            $statusCode = 419;
            return $this->e($statusCode);
        }

        if($exception instanceof FatalErrorException && !env('APP_DEBUG')){
            // 自定义处理的异常http状态码页面
            if($isGetMethod)
                return $this->errorPage(500, 'error', 500);
            else
                return $this->e(500);
        }

        return parent::render($request, $exception);
    }
}
