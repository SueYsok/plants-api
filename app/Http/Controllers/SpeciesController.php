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
     * @param Request $Request
     * @param Router  $Route
     * @param Species $Species
     */
    public function __construct(Request $Request, Router $Route, Species $Species)
    {
        parent::__construct($Request, $Route);

        $this->Species = $Species;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneSpecies()
    {
        $speciesId = $this->Route->input('species_id');

        $SpeciesEntity = $this->Species->one($speciesId);

        return $this->response()->item($SpeciesEntity, new SpeciesTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allSpecies()
    {
        $genusId = $this->Route->input('genus_id');

        $SpeciesCollection = $this->Species->many($genusId);

        return $this->response()->collection($SpeciesCollection, new SpeciesTransformer);
    }

}