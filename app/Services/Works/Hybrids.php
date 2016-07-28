<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午4:58
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Contracts\Storage;
use App\Services\Entities\HybridsEntity;
use App\Services\Works\Resources\HybridsEntities;
use App\Services\Works\Resources\HybridsRepositories;


/**
 * Class Hybrids
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Hybrids extends Work implements Selection, Storage
{

    use HybridsRepositories, HybridsEntities;

    /**
     * @var HybridsEntity
     */
    protected $HybridsEntity;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return mixed
     */
    public function one($id, ...$input)
    {
        $Model = $this->hybridsRepository()->oneById($id);

        $HybridsEntity = $this->hybridsEntity()->create($Model);
        $this->setHybridsEntity($HybridsEntity);

        return $HybridsEntity;
    }

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function many(...$input)
    {
        $query = [];
        if ($input[0]) {
            $query['1_plants_id'] = $input[0];
        }
        if ($input[1]) {
            $query['2_plants_id'] = $input[1];
        }

        $Collection = $this->hybridsRepository()->manyByQuery($query);

        return $this->hybridsEntity()->create($Collection);
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
     * @return HybridsEntity
     */
    public function add(...$input)
    {
        $title = $input[0];
        $alias = $input[1];
        $description = $input[2];
        $content = $input[3];
        $coversId = $input[4];
        $leftPlantsId = isset($input[5][0]) ? $input[5][0] : null;
        $rightPlantsId = isset($input[5][1]) ? $input[5][1] : null;
        $tagsIds = $input[6];
        $userId = $input[7];

        $HybridsModel = $this->hybridsRepository()->add($title, $alias, $description, $content,
            $coversId, $leftPlantsId, $rightPlantsId, $tagsIds, $userId);

        $HybridsEntity = $this->hybridsEntity()->create($HybridsModel);

        $this->setHybridsEntity($HybridsEntity);

        return $HybridsEntity;
    }

    /**
     * @param array $input
     *
     * @return HybridsEntity
     */
    public function edit(...$input)
    {
        $title = $input[0];
        $alias = $input[1];
        $description = $input[2];
        $content = $input[3];
        $coversId = $input[4];
        $leftPlantsId = isset($input[5][0]) ? $input[5][0] : null;
        $rightPlantsId = isset($input[5][1]) ? $input[5][1] : null;
        $tagsIds = $input[6];

        $HybridsModel = $this->hybridsRepository()->edit($this->HybridsEntity->getId(),
            $title, $alias, $description, $content, $coversId, $leftPlantsId, $rightPlantsId, $tagsIds);

        $HybridsEntity = $this->hybridsEntity()->create($HybridsModel);

        $this->setHybridsEntity($HybridsEntity);

        return $HybridsEntity;
    }

    /**
     * @param int   $hybridsId
     * @param array $input
     *
     * @return bool
     */
    public function delete($hybridsId, ...$input)
    {
        $this->hybridsRepository()->deleteById($hybridsId);

        return true;
    }

    /**
     * @param HybridsEntity $HybridsEntity
     */
    public function setHybridsEntity($HybridsEntity)
    {
        $this->HybridsEntity = $HybridsEntity;
    }

}