<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Router;


/**
 * Class Controller
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Request
     */
    protected $Request;
    /**
     * @var ResponseFactory
     */
    protected $Response;
    /**
     * @var Router
     */
    protected $Route;

    /**
     * @param Request         $Request
     * @param ResponseFactory $Response
     */
    public function __construct(Request $Request, ResponseFactory $Response, Router $Route)
    {
        $this->Request = $Request;
        $this->Response = $Response;
        $this->Route = $Route;
    }
}
