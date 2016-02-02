<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:44
 */

namespace App\Http\Controllers;

use App\Http\Transformers\BusinessesPlantsTransformer;
use App\Http\Transformers\BusinessesTransformer;
use App\Services\Works\Businesses;
use App\Services\Works\BusinessesPlants;
use Dingo\Api\Http\Request;
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
     * @var BusinessesPlants
     */
    protected $BusinessesPlants;

    /**
     * @param Request          $Request
     * @param Router           $Route
     * @param Businesses       $Businesses
     * @param BusinessesPlants $BusinessesPlants
     */
    public function __construct(
        Request $Request,
        Router $Route,
        Businesses $Businesses,
        BusinessesPlants $BusinessesPlants
    ) {
        parent::__construct($Request, $Route);

        $this->Businesses = $Businesses;
        $this->BusinessesPlants = $BusinessesPlants;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneBusiness()
    {
        $businessesId = $this->Route->input('businesses_id');

        $BusinessesEntity = $this->Businesses->one($businessesId);

        return $this->response()->item($BusinessesEntity, new BusinessesTransformer, ['key'=>'user']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allBusinesses()
    {
        $BusinessesCollection = $this->Businesses->many();

        return $this->response()->collection($BusinessesCollection, new BusinessesTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allPlants()
    {
        $businessesId = $this->Route->input('businesses_id');

        $BusinessesCollection = $this->BusinessesPlants->many($businessesId);

        return $this->response()->collection($BusinessesCollection, new BusinessesPlantsTransformer);
    }

}