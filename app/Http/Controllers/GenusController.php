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
     * @param Request $Request
     * @param Router  $Route
     * @param Genus   $Genus
     */
    public function __construct(Request $Request, Router $Route, Genus $Genus)
    {
        parent::__construct($Request, $Route);

        $this->Genus = $Genus;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneGenus()
    {
        $genusId = $this->Route->input('genus_id');

        $GenusEntity = $this->Genus->one($genusId);

        return $this->response()->item($GenusEntity, new GenusTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allGenus()
    {
        $familyId = $this->Route->input('family_id');

        $GenusCollection = $this->Genus->many($familyId);

        return $this->response()->collection($GenusCollection, new GenusTransformer);
    }

}