<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Traits\ApiResponser;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function handleException( Throwable $e)
    {
        
        
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->reportable(function (Throwable $e){

        });

        $this->renderable(function (Throwable $e) {

            if ($e instanceof ValidationException) {
                return $this->errorResponse($e->errors(),$e->status);
            }

            else if ($e instanceof ModelNotFoundException)
            {
                return $this->errorResponse("Model not found",404);
            }

            else if ($e instanceof AuthenticationException)
            {
                return $this->errorResponse("Unauthenticated",401);
            }

            else if ($e instanceof AuthorizationException)
            {
                return $this->errorResponse("Unauthorized for the action",403);
            }

            else if ($e instanceof NotFoundHttpException)
            {
                return $this->errorResponse("Resource not Found",404);
            }

            else if ($e instanceof MethodNotAllowedHttpException)
            {
                return $this->errorResponse("Current method not allowed",405);
            }

            else if ($e instanceof HttpException)
            {
                return $this->errorResponse($e->getMessage(),$e->getStatusCode());
            }

            else if ($e instanceof QueryException)
            {   
                if($e->errorInfo[1]==1451)
                {
                    return $this->errorResponse("Current instance is in relation with other resources thus cannot be removed",409);    
                }
                
            }
            else 
            {
                return $this->errorResponse($e->getMessage(),$e->getCode());
            
                //return $this->errorResponse('Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
