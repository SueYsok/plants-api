<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:44
 */

namespace App\Http\Controllers;

use App\Services\Works\BusinessesPlants;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Router;


/**
 * Class BusinessesController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class BusinessesPlantsController extends Controller
{

    /**
     * @var BusinessesPlants
     */
    protected $BusinessesPlants;

    /**
     * @param Request          $Request
     * @param ResponseFactory  $Response
     * @param Router           $Route
     * @param BusinessesPlants $BusinessesPlants
     */
    public function __construct(
        Request $Request,
        ResponseFactory $Response,
        Router $Route,
        BusinessesPlants $BusinessesPlants
    ) {
        parent::__construct($Request, $Response, $Route);

        $this->BusinessesPlants = $BusinessesPlants;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $businessesId = $this->Route->input('businesses_id');

        $BusinessesCollection = $this->BusinessesPlants->many($businessesId);

        return $this->Response->json($BusinessesCollection);
    }

}


