<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/21
 * Time: 下午6:10
 */

namespace App\Http\Controllers;

use App\Http\Transformers\KKChangesTransformer;
use App\Http\Transformers\KKDatesTransformer;
use App\Http\Transformers\KKSeedsTransformer;
use App\Services\Works\KK;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;


/**
 * Class KKController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class KKController extends Controller
{

    /**
     * @var KK
     */
    protected $KK;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param KK         $KK
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, KK $KK)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->KK = $KK;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function news()
    {
        $DatesCollection = $this->KK->manyDates();

        $SeedsChanges = $this->KK->changes(
            $DatesCollection->shift()->date->toDateString(),
            $DatesCollection->shift()->date->toDateString()
        );

        return $this->response->item($SeedsChanges, new KKChangesTransformer);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function dates()
    {
        $DatesCollection = $this->KK->manyDates();

        return $this->response()->collection($DatesCollection, new KKDatesTransformer);
    }

    /**
     * @param string $date
     *
     * @return \Dingo\Api\Http\Response
     */
    public function dateSeeds($date)
    {
        $class1 = $this->Request->get('class_1');
        $class2 = $this->Request->get('class_2');
        $specPkt = $this->Request->get('spec_pkt');
        $spec100 = $this->Request->get('spec_100');
        $spec1000 = $this->Request->get('spec_1000');
        $spec10000 = $this->Request->get('spec_10000');

        $SeedsCollection = $this->KK->manySeeds($date, $class1, $class2, $specPkt, $spec100, $spec1000, $spec10000);

        return $this->response()->collection($SeedsCollection, new KKSeedsTransformer);
    }

}