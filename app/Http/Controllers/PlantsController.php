<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/2
 * Time: 下午3:22
 */

namespace App\Http\Controllers;

use App\Services\Works\Plants;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
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
     * @param Request         $Request
     * @param ResponseFactory $Response
     * @param Router          $Route
     * @param Plants          $Plants
     */
    public function __construct(Request $Request, ResponseFactory $Response, Router $Route, Plants $Plants)
    {
        parent::__construct($Request, $Response, $Route);

        $this->Plants = $Plants;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function one()
    {
        $plantsId = $this->Route->input('plants_id');

        $PlantsEntity = $this->Plants->one($plantsId);

        return $this->Response->json($PlantsEntity);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $familyId = $this->Request->input('family_id');
        $genusId = $this->Request->input('genus_id');
        $speciesId = $this->Request->input('species_id');
        $subspeciesId = $this->Request->input('subspecies_id');
        $varietasId = $this->Request->input('varietas_id');

        $PlantsCollection = $this->Plants->many($familyId, $genusId, $speciesId, $subspeciesId, $varietasId);

        return $this->Response->json($PlantsCollection);
    }

}