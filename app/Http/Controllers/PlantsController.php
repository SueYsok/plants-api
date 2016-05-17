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
use LucaDegasperi\OAuth2Server\Authorizer;

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
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Plants     $Plants
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Plants $Plants)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Plants = $Plants;
    }

    /**
     * @param int $plantsId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function onePlant($plantsId)
    {
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
        $tagsTitle = $this->Request->input('tags_title');
        $businessesId = $this->Request->input('businesses_id');

        $PlantsCollection = $this->Plants->many(
            $familyId, $genusId, $speciesId, $subspeciesId, $varietasId, $tagsId, $tagsTitle, $businessesId);

        return $this->response()->collection($PlantsCollection, new PlantsTransformer);
    }

    public function addPlant()
    {
        //todo
    }

    public function editPlant($plantId)
    {
        //todo
    }

    public function destroyPlant($plantId)
    {
        //todo
    }

}