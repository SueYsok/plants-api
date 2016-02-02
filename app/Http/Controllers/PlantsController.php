<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/2
 * Time: 下午3:22
 */

namespace App\Http\Controllers;

use App\Http\Transformers\PlantsTransformer;
use App\Services\Works\Plants;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;

/**
 * Class PlantsController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class PlantsController extends Controller
{

    /**
     * @var Plants
     */
    protected $Plants;

    /**
     * @param Request $Request
     * @param Router  $Route
     * @param Plants  $Plants
     */
    public function __construct(Request $Request, Router $Route, Plants $Plants)
    {
        parent::__construct($Request, $Route);

        $this->Plants = $Plants;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function onePlant()
    {
        $plantsId = $this->Route->input('plants_id');

        $PlantsEntity = $this->Plants->one($plantsId);

        return $this->response()->item($PlantsEntity, new PlantsTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allPlants()
    {
        $familyId = $this->Request->input('family_id');
        $genusId = $this->Request->input('genus_id');
        $speciesId = $this->Request->input('species_id');
        $subspeciesId = $this->Request->input('subspecies_id');
        $varietasId = $this->Request->input('varietas_id');
        $tagsId = $this->Request->input('tags_id');
        $businessesId = $this->Request->input('businesses_id');

        $PlantsCollection = $this->Plants->many(
            $familyId, $genusId, $speciesId, $subspeciesId, $varietasId, $tagsId, $businessesId);

        return $this->response()->collection($PlantsCollection, new PlantsTransformer);
    }

}