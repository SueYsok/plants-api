<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/3/1
 * Time: 上午10:27
 */

namespace App\Http\Controllers;

use App\Exceptions\WorkException;
use App\Services\Works\Images;
use App\Services\Works\Work;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;


/**
 * Class ImagesController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class ImagesController extends Controller
{

    /**
     * @var Images
     */
    protected $Images;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Images     $Images
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Images $Images)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Images = $Images;
    }

    /**
     * @param int $plantsId
     *
     * @return \Dingo\Api\Http\Response
     */
    public function addPlantImage($plantsId)
    {
        return $this->addImage($plantsId, 'plants');
    }

    /**
     * @param int $imagesId
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroyPlantImage($imagesId)
    {
        return $this->destroyImage($imagesId, 'plants');
    }

    /**
     * @param int $hybridsId
     *
     * @return \Dingo\Api\Http\Response|null
     */
    public function addHybridImage($hybridsId)
    {
        return $this->addImage($hybridsId, 'hybrids');
    }

    /**
     * @param int $imagesId
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroyHybridImage($imagesId)
    {
        return $this->destroyImage($imagesId, 'hybrids');
    }

    /**
     * @param int    $objectId
     * @param string $key
     *
     * @return \Dingo\Api\Http\Response|null
     */
    private function addImage($objectId, $key)
    {
        $userId = $this->Authorizer->getResourceOwnerId();
        $image = $this->Request->file('image');

        try {
            $ImageFile = app('image')->make($image);
        } catch (\Exception $e) {
            $this->response()->errorBadRequest();

            return null;
        }

        try {
            $this->Images->add($objectId, $userId, $ImageFile, $key);
        } catch (WorkException $e) {
            switch ($e->getCode()) {
                case Work::PLANTS_MODEL_NOT_FOUND:
                    $this->response()->errorBadRequest();
                    break;
                default:
                    $this->response()->errorForbidden();
            }
        }

        return $this->response()->created();
    }

    /**
     * @param int    $imagesId
     * @param string $key
     *
     * @return \Dingo\Api\Http\Response
     */
    private function destroyImage($imagesId, $key)
    {
        try {
            $this->Images->delete($imagesId, $key);
        } catch (WorkException $e) {
            switch ($e->getCode()) {
                case Work::NOT_DELETE_FILE:
                    $this->response()->errorForbidden();
                    break;
                default:
                    $this->response()->errorForbidden();
            }
        }

        return $this->response()->noContent();
    }

}