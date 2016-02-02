<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('Dingo\Api\Exception\Handler')->register(function (ModelNotFoundException $exception) {
            /** @var \Dingo\Api\Http\Response\Factory $Factory */
            $Factory = app('Dingo\Api\Http\Response\Factory');
            $Factory->errorNotFound();
        });

        $response = $next($request);

        return $response;
    }
}
