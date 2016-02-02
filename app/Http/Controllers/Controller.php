<?php

namespace App\Http\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Router;


/**
 * Class Controller
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    /**
     * @var Request
     */
    protected $Request;
    /**
     * @var Router
     */
    protected $Route;

    /**
     * @param Request $Request
     */
    public function __construct(Request $Request, Router $Route)
    {
        $this->Request = $Request;
        $this->Route = $Route;
    }
}
