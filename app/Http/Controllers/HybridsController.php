<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午5:11
 */

namespace App\Http\Controllers;

use App\Http\Transformers\HybridsTransformer;
use App\Services\Works\Hybrids;
use App\Services\Works\Tags;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;


/**
 * Class HybridsController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class HybridsController extends Controller
{

    /**
     * @var Hybrids
     */
    protected $Hybrids;
    /**
     * @var Tags
     */
    protected $Tags;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Hybrids    $Hybrids
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Hybrids $Hybrids, Tags $Tags)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Hybrids = $Hybrids;
        $this->Tags = $Tags;
    }

    /**
     * @param int $hybridsId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneHybrid($hybridsId)
    {
        $HybridsEntity = $this->Hybrids->one($hybridsId);

        return $this->response()->item($HybridsEntity, new HybridsTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allHybrids()
    {
        $plantsId = $this->Request->input('plants_id');
        $secondPlantsId = $this->Request->input('second_plants_id');

        $HybridsCollection = $this->Hybrids->many($plantsId, $secondPlantsId);

        return $this->response()->collection($HybridsCollection, new HybridsTransformer);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function addHybrid()
    {
        $userId = $this->Authorizer->getResourceOwnerId();
        $title = $this->Request->input('title');
        $alias = $this->Request->input('alias');
        $description = $this->Request->input('description');
        $content = $this->Request->input('content');
        $plantsIds = json_decode($this->Request->input('plants_ids'), true) ?: [];
        $tagsIds = json_decode($this->Request->input('tags_ids'), true) ?: [];
        $tagsTitles = json_decode($this->Request->input('tags_title'), true) ?: [];

        $TagsCollection = $this->Tags->addNoDuplicates($tagsIds, $tagsTitles, $userId);
        $tagsIds = array_pluck($TagsCollection->toArray(), 'id');

        $this->Hybrids->add($title, $alias, $description, $content, null,
            $plantsIds, $tagsIds, $userId);

        if (!empty($tagsIds)) {
            $this->Tags->incMany($tagsIds);
        }

        return $this->response()->created();
    }

    /**
     * @param int $hybridsId
     *
     * @return \Dingo\Api\Http\Response|null
     */
    public function editHybrid($hybridsId)
    {
        $userId = $this->Authorizer->getResourceOwnerId();
        $title = $this->Request->input('title');
        $alias = $this->Request->input('alias');
        $description = $this->Request->input('description');
        $content = $this->Request->input('content');
        $cover = $this->Request->input('cover');
        $plantsIds = json_decode($this->Request->input('plants_ids'), true) ?: [];
        $tagsIds = json_decode($this->Request->input('tags_ids'), true) ?: [];
        $tagsTitles = json_decode($this->Request->input('tags_title'), true) ?: [];

        if ($HybridsEntity = $this->Hybrids->one($hybridsId)) {
            $TagsCollection = $this->Tags->addNoDuplicates($tagsIds, $tagsTitles, $userId);
            $tagsIds = array_pluck($TagsCollection->toArray(), 'id');

            $oldTagsIds = array_pluck($HybridsEntity->getTags()->toArray(), 'id');

            $this->Hybrids->edit($title, $alias, $description, $content, $cover, $plantsIds, $tagsIds);

            if (!empty($oldTagsIds)) {
                $this->Tags->decMany($oldTagsIds);
            }
            if (!empty($tagsIds)) {
                $this->Tags->incMany($tagsIds);
            }

            return $this->response()->noContent();
        } else {
            $this->response->errorNotFound();

            return null;
        }
    }

    /**
     * @param int $hybridsId
     *
     * @return \Dingo\Api\Http\Response|null
     */
    public function destroyHybrid($hybridsId)
    {
        if ($HybridsEntity = $this->Hybrids->one($hybridsId)) {
            $oldTagsIds = array_pluck($HybridsEntity->getTags()->toArray(), 'id');

            $this->Hybrids->delete($hybridsId);

            if (!empty($oldTagsIds)) {
                $this->Tags->decMany($oldTagsIds);
            }

            return $this->response()->noContent();
        } else {
            $this->response->errorNotFound();

            return null;
        }
    }

}