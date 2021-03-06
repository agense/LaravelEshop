<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttp‌​Exception;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

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

        //Modify to redirect admin requets to admin login page
        if($exception instanceof AuthenticationException){
            $guard = array_get($exception->guards(), 0);
            switch($guard){
                case 'admin':
                return redirect(route('admin.login'));
                break;
                default:
                return redirect(route('login'));
                break;
            }
        }
        //Handle authorization exceptions
        if ($exception instanceof AuthorizationException) {
            if($request->wantsJson()) {
                return response()->json(['message' => $exception->getMessage()], 403);
            }
            return redirect()->back()->with('error_message', $exception->getMessage());
        }

        //Handle Http exceptions
        if ($exception instanceof HttpException) {
            if($request->wantsJson()) {
                return response()->json(['message' => $exception->getMessage()], $exception->getStatusCode());
            }
            return redirect()->back()->with('error_message', $exception->getMessage());
        }

        //Handle too large posts
        if ($exception instanceof PostTooLargeException) {
            return redirect()->back()->withErrors("Size of attached file should be less ".ini_get("upload_max_filesize")."B", 'addNote');
        }

        return parent::render($request, $exception);
    }
}
