<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/2
 * Time: 下午3:23
 */

namespace App\Http\Controllers;

use App\Http\Transformers\SpeciesTransformer;
use App\Services\Works\Species;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;


/**
 * Class SpeciesController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class SpeciesController extends Controller
{

    /**
     * @var Species
     */
    protected $Species;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Species    $Species
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Species $Species)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Species = $Species;
    }

    /**
     * @param int $speciesId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneSpecies($speciesId)
    {
        $SpeciesEntity = $this->Species->one($speciesId);

        return $this->response()->item($SpeciesEntity, new SpeciesTransformer);
    }

    /**
     * @param int $genusId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allSpecies($genusId)
    {
        $SpeciesCollection = $this->Species->many($genusId);

        return $this->response()->collection($SpeciesCollection, new SpeciesTransformer);
    }

    /**
     * @param int $speciesId
     *
     * @return \Dingo\Api\Http\Response
     */
    public function editSpecies($speciesId)
    {
        $title = $this->Request->get('title');
        $chineseTitle = $this->Request->get('chinese_title');
        $description = $this->Request->get('description');

        if (!$this->Species->edit($speciesId, $title, $chineseTitle, $description)) {
            $this->response()->errorInternal();
        }

        return $this->response()->noContent();
    }

}