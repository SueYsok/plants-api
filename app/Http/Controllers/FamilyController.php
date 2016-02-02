<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午3:21
 */

namespace App\Http\Controllers;

use App\Http\Transformers\FamilyTransformer;
use App\Services\Works\Family;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;


/**
 * Class FamilyController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class FamilyController extends Controller
{

    /**
     * @var Family
     */
    protected $Family;

    /**
     * @param Request $Request
     * @param Router  $Route
     * @param Family  $Family
     */
    public function __construct(Request $Request, Router $Route, Family $Family)
    {
        parent::__construct($Request, $Route);

        $this->Family = $Family;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneFamily()
    {
        $familyId = $this->Route->input('family_id');

        $FamilyEntity = $this->Family->one($familyId);

        return $this->response()->item($FamilyEntity, new FamilyTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allFamily()
    {
        $FamilyCollection = $this->Family->many();

        return $this->response()->collection($FamilyCollection, new FamilyTransformer);
    }

}