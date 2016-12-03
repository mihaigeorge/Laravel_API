<?php

namespace App\Exceptions;

use Response;
use Exception;
use App\Exceptions\APIException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {   
        // If Request is from API convert exceptions to APIException
        if ($request->is('api/*')) {
            if ($e instanceof ModelNotFoundException) {
                throw new APIException("notFound", HttpResponse::HTTP_NOT_FOUND);
            }
            else if ($e instanceof HttpResponseException) {
                $statusCode = $e->getResponse()->getStatusCode();
                if ($statusCode == 403) {
                    throw new APIException("forbidden", HttpResponse::HTTP_FORBIDDEN);
                }
            }
        }
        
        // if Exception is APIException return error Response
        if ($e instanceof APIException) {
            
            return Response::json([
                'status' => 'error',
                'errors' => $e->getErrors()
            ], $e->getStatusCode());

        } else {

            return parent::render($request, $e);
        }
    }
}
