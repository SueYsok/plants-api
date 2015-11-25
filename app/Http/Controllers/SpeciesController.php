<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/2
 * Time: 下午3:23
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Works\Species;
use Illuminate\Routing\ResponseFactory;
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
     * @param Request         $Request
     * @param ResponseFactory $Response
     * @param Router          $Route
     * @param Species         $Species
     */
    public function __construct(Request $Request, ResponseFactory $Response, Router $Route, Species $Species)
    {
        parent::__construct($Request, $Response, $Route);

        $this->Species = $Species;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function one()
    {
        $speciesId = $this->Route->input('species_id');
        $mode = $this->Request->input('mode');

        $SpeciesEntity = $this->Species->one($speciesId, $mode);

        return $this->Response->json($SpeciesEntity);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $genusId = $this->Route->input('genus_id');

        $SpeciesCollection = $this->Species->many($genusId);

        return $this->Response->json($SpeciesCollection);
    }

}