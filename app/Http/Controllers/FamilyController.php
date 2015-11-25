<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午3:21
 */

namespace App\Http\Controllers;

use App\Services\Works\Family;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
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
     * @param Request         $Request
     * @param ResponseFactory $Response
     * @param Router          $Route
     * @param Family          $Family
     */
    public function __construct(Request $Request, ResponseFactory $Response, Router $Route, Family $Family)
    {
        parent::__construct($Request, $Response, $Route);

        $this->Family = $Family;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function one()
    {
        $familyId = $this->Route->input('family_id');

        $FamilyEntity = $this->Family->one($familyId);

        return $this->Response->json($FamilyEntity);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $FamilyCollection = $this->Family->many();

        return $this->Response->json($FamilyCollection);
    }

}