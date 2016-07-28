<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/2
 * Time: 下午3:22
 */

namespace App\Http\Controllers;

use App\Http\Transformers\PlantsTransformer;
use App\Services\Works\Plants;
use App\Services\Works\Tags;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;
use LucaDegasperi\OAuth2Server\Authorizer;

/**
 * Class PlantsController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class PlantsController extends Controller
{

    /**
     * @var Plants
     */
    protected $Plants;
    /**
     * @var Tags
     */
    protected $Tags;

    /**
     * @param Request    $Request
     * @param Router     $Route
     * @param Authorizer $Authorizer
     * @param Plants     $Plants
     * @param Tags       $Tags
     */
    public function __construct(Request $Request, Router $Route, Authorizer $Authorizer, Plants $Plants, Tags $Tags)
    {
        parent::__construct($Request, $Route, $Authorizer);

        $this->Plants = $Plants;
        $this->Tags = $Tags;
    }

    /**
     * @param int $plantsId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function onePlant($plantsId)
    {
        $PlantsEntity = $this->Plants->one($plantsId);

        return $this->response()->item($PlantsEntity, new PlantsTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allPlants()
    {
        $familyId = $this->Request->input('family_id');
        $genusId = $this->Request->input('genus_id');
        $speciesId = $this->Request->input('species_id');
        $subspeciesId = $this->Request->input('subspecies_id');
        $varietasId = $this->Request->input('varietas_id');
        $tagsId = $this->Request->input('tags_id');
        $tagsTitle = $this->Request->input('tags_title');
        $businessesId = $this->Request->input('businesses_id');

        $PlantsCollection = $this->Plants->many(
            $familyId, $genusId, $speciesId, $subspeciesId, $varietasId, $tagsId, $tagsTitle, $businessesId);

        return $this->response()->collection($PlantsCollection, new PlantsTransformer);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function addPlant()
    {
        $userId = $this->Authorizer->getResourceOwnerId();
        $title = $this->Request->input('title');
        $alias = $this->Request->input('alias');
        $description = $this->Request->input('description');
        $content = $this->Request->input('content');
        $familyId = $this->Request->input('family_id');
        $genusId = $this->Request->input('genus_id');
        $speciesId = $this->Request->input('species_id');
        $subspeciesId = $this->Request->input('subspecies_id');
        $varietasId = $this->Request->input('varietas_id');
        $tagsIds = json_decode($this->Request->input('tags_ids'), true) ?: [];
        $tagsTitles = json_decode($this->Request->input('tags_title'), true) ?: [];
        $samePlantsId = $this->Request->input('same_plants_id');

        $TagsCollection = $this->Tags->addNoDuplicates($tagsIds, $tagsTitles, $userId);
        $tagsIds = array_pluck($TagsCollection->toArray(), 'id');

        $this->Plants->add($title, $alias, $description, $content, null,
            $familyId, $genusId, $speciesId, $subspeciesId, $varietasId,
            $tagsIds, $userId);

        if ($samePlantsId) {
            $this->Plants->bindSames($samePlantsId);
        }

        if (!empty($tagsIds)) {
            $this->Tags->incMany($tagsIds);
        }

        return $this->response()->created();
    }

    /**
     * @param int $plantsId
     *
     * @return \Dingo\Api\Http\Response|null
     */
    public function editPlant($plantsId)
    {
        $userId = $this->Authorizer->getResourceOwnerId();
        $title = $this->Request->input('title');
        $alias = $this->Request->input('alias');
        $description = $this->Request->input('description');
        $content = $this->Request->input('content');
        $coversId = $this->Request->input('covers_id');
        $familyId = $this->Request->input('family_id');
        $genusId = $this->Request->input('genus_id');
        $speciesId = $this->Request->input('species_id');
        $subspeciesId = $this->Request->input('subspecies_id');
        $varietasId = $this->Request->input('varietas_id');
        $tagsIds = json_decode($this->Request->input('tags_ids'), true) ?: [];
        $tagsTitles = json_decode($this->Request->input('tags_title'), true) ?: [];

        if ($PlantsEntity = $this->Plants->one($plantsId)) {
            $TagsCollection = $this->Tags->addNoDuplicates($tagsIds, $tagsTitles, $userId);
            $tagsIds = array_pluck($TagsCollection->toArray(), 'id');

            $oldTagsIds = array_pluck($PlantsEntity->getTags()->toArray(), 'id');

            $this->Plants->edit($title, $alias, $description, $content, $coversId,
                $familyId, $genusId, $speciesId, $subspeciesId, $varietasId, $tagsIds);

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
     * @param int $plantsId
     *
     * @return \Dingo\Api\Http\Response
     */
    public function destroyPlant($plantsId)
    {
        if ($PlantsEntity = $this->Plants->one($plantsId)) {

            $oldTagsIds = array_pluck($PlantsEntity->getTags()->toArray(), 'id');

            $this->Plants->delete($plantsId);

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