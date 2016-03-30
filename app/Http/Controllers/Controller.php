<?php

namespace App\Http\Controllers;

use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;

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
     * @var Authorizer
     */
    protected $Authorizer;

    /**
     * @var int
     */
    protected $myId;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer)
    {
        $this->Request = $Request;
        $this->Route = $Route;
        $this->Authorizer = $Authorizer;
    }

}
