<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午5:11
 */

namespace App\Http\Controllers;

use App\Http\Transformers\HybridsTransformer;
use App\Services\Works\Hybrids;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;


/**
 * Class HybridsController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class HybridsController extends Controller
{

    /**
     * @var Hybrids
     */
    protected $Hybrids;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Hybrids    $Hybrids
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Hybrids $Hybrids)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Hybrids = $Hybrids;
    }

    /**
     * @param int $hybridsId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneHybrids($hybridsId)
    {
        $HybridsEntity = $this->Hybrids->one($hybridsId);

        return $this->response()->item($HybridsEntity, new HybridsTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allHybrids()
    {
        $plantsId = $this->Request->input('plants_id');
        $secondPlantsId = $this->Request->input('second_plants_id');

        $HybridsCollection = $this->Hybrids->many($plantsId, $secondPlantsId);

        return $this->response()->collection($HybridsCollection, new HybridsTransformer);
    }

}