<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午2:35
 */

namespace App\Http\Controllers;

use App\Http\Transformers\GenusTransformer;
use App\Services\Works\Genus;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;


/**
 * Class GenusController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class GenusController extends Controller
{

    /**
     * @var Genus
     */
    protected $Genus;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Genus      $Genus
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Genus $Genus)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Genus = $Genus;
    }

    /**
     * @param int $genusId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneGenus($genusId)
    {
        $GenusEntity = $this->Genus->one($genusId);

        return $this->response()->item($GenusEntity, new GenusTransformer);
    }

    /**
     * @param int $familyId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allGenus($familyId)
    {
        $GenusCollection = $this->Genus->many($familyId);

        return $this->response()->collection($GenusCollection, new GenusTransformer);
    }

}