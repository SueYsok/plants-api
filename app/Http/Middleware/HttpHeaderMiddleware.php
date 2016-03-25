<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/3/25
 * Time: 下午10:42
 */

namespace App\Http\Middleware;

use Closure;


/**
 * Class HttpHeaderMiddleware
 *
 * @package App\Http\Middleware
 * @author  sueysok
 */
class HttpHeaderMiddleware
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
        /** @var \Dingo\Api\Http\Response $response */
        $response = $next($request);

        $response->withHeader('Access-Control-Allow-Origin', '*');
        $response->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    }

}
