<?php

namespace App\Exceptions;

use App\Exceptions\DomainExceptions\AuthValidateException;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $ex) {
            $response = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => $ex->getMessage(),
                'timestamp' => now()->setTimezone('America/Sao_Paulo')->format('d-m-Y H:i')
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        });
    }
}
