<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:44
 */

namespace App\Http\Controllers;

use App\Services\Works\Businesses;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Router;


/**
 * Class BusinessesController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class BusinessesController extends Controller
{

    /**
     * @var Businesses
     */
    protected $Businesses;

    /**
     * @param Request         $Request
     * @param ResponseFactory $Response
     * @param Router          $Route
     * @param Businesses      $Businesses
     */
    public function __construct(Request $Request, ResponseFactory $Response, Router $Route, Businesses $Businesses)
    {
        parent::__construct($Request, $Response, $Route);

        $this->Businesses = $Businesses;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function one()
    {
        $businessesId = $this->Route->input('businesses_id');

        $BusinessesEntity = $this->Businesses->one($businessesId);

        return $this->Response->json($BusinessesEntity);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $BusinessesCollection = $this->Businesses->many();

        return $this->Response->json($BusinessesCollection);
    }

}