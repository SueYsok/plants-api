<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午2:35
 */

namespace App\Http\Controllers;

use App\Services\Works\Genus;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
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
     * @param Request         $Request
     * @param ResponseFactory $Response
     * @param Router          $Route
     * @param Genus           $Genus
     */
    public function __construct(Request $Request, ResponseFactory $Response, Router $Route, Genus $Genus)
    {
        parent::__construct($Request, $Response, $Route);

        $this->Genus = $Genus;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function one()
    {
        $genusId = $this->Route->input('genus_id');

        $GenusEntity = $this->Genus->one($genusId);

        return $this->Response->json($GenusEntity);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $familyId = $this->Route->input('family_id');

        $GenusCollection = $this->Genus->many($familyId);

        return $this->Response->json($GenusCollection);
    }

}