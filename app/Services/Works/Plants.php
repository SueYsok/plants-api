<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:51
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Contracts\Storage;
use App\Services\Entities\PlantsEntity;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;


/**
 * Class Plants
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Plants extends Work implements Selection, Storage
{

    use PlantsRepositories, PlantsEntities;

    /**
     * @var PlantsEntity
     */
    protected $PlantsEntity;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\PlantsEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->plantsRepository()->oneById($id);

        $PlantsEntity = $this->plantsEntity()->create($Model);

        $this->setPlantsEntity($PlantsEntity);

        return $PlantsEntity;
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $query = [];
        if ($input[0]) {
            $query['family_id'] = $input[0];
        }
        if ($input[1]) {
            $query['genus_id'] = $input[1];
        }
        if ($input[2]) {
            $query['species_id'] = $input[2];
        }
        if ($input[3]) {
            $query['subspecies_id'] = $input[3];
        }
        if ($input[4]) {
            $query['varietas_id'] = $input[4];
        }
        if ($input[5]) {
            $query['tags_id'] = $input[5];
        }
        if ($input[6]) {
            $query['tags_title'] = $input[6];
        }
        if ($input[7]) {
            $query['businesses_id'] = $input[7];
        }

        $Collection = $this->plantsRepository()->manyByQuery($query);

        return $this->plantsEntity()->create($Collection);
    }

    /**
     * @param mixed $index
     *
     * @return int
     */
    public function id($index)
    {
        // TODO: Implement id() method.
    }

    /**
     *
     * @param array $input
     *
     * @return PlantsEntity
     */
    public function add(...$input)
    {
        $title = $input[0];
        $alias = $input[1] ?: null;
        $description = $input[2] ?: null;
        $content = $input[3] ?: null;
        $coversId = $input[4] ?: null;
        $familyId = $input[5];
        $genusId = $input[6];
        $speciesId = $input[7];
        $subspeciesId = $input[8];
        $varietasId = $input[9];
        $tagsIds = $input[10];
        $userId = $input[11];

        $PlantsModel = $this->plantsRepository()->add($title, $alias, $description, $content,
            $coversId, $familyId, $genusId, $speciesId, $subspeciesId, $varietasId,
            $tagsIds, $userId);

        $PlantsEntity = $this->plantsEntity()->create($PlantsModel);

        $this->setPlantsEntity($PlantsEntity);

        return $PlantsEntity;
    }

    /**
     * @param array $input
     *
     * @return PlantsEntity
     */
    public function edit(...$input)
    {
        $title = $input[0];
        $alias = $input[1];
        $description = $input[2];
        $content = $input[3];
        $coversId = $input[4];
        $familyId = $input[5];
        $genusId = $input[6];
        $speciesId = $input[7];
        $subspeciesId = $input[8];
        $varietasId = $input[9];
        $tagsIds = $input[10];

        $PlantsModel = $this->plantsRepository()->edit($this->PlantsEntity->getId(),
            $title, $alias, $description, $content, $coversId, $familyId, $genusId,
            $speciesId, $subspeciesId, $varietasId, $tagsIds);

        $PlantsEntity = $this->plantsEntity()->create($PlantsModel);

        $this->setPlantsEntity($PlantsEntity);

        return $PlantsEntity;
    }

    /**
     * @param int   $plantsId
     * @param array $input
     *
     * @return bool
     */
    public function delete($plantsId, ...$input)
    {
        $this->plantsSameRepository()->destroy($plantsId);
        $this->plantsRepository()->deleteById($plantsId);

        return true;
    }

    /**
     * @param int $samePlantsId
     */
    public function bindSames($samePlantsId)
    {
        $this->plantsSameRepository()
            ->add($this->PlantsEntity->getId(), $samePlantsId);
    }

    /**
     *
     */
    public function unbindSames()
    {
        $this->plantsSameRepository()->destroy($this->PlantsEntity->getId());
    }

    /**
     * @param PlantsEntity $PlantsEntity
     */
    public function setPlantsEntity($PlantsEntity)
    {
        $this->PlantsEntity = $PlantsEntity;
    }

    /**
     * @return PlantsEntity
     */
    public function getPlantsEntity()
    {
        return $this->PlantsEntity;
    }

}