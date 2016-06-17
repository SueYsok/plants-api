<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午6:14
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Contracts\Storage;
use App\Services\Entities\SpeciesEntity;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;


/**
 * Class Species
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Species extends Work implements Selection, Storage
{

    use PlantsRepositories, PlantsEntities;

    /**
     * @var SpeciesEntity
     */
    protected $SpeciesEntity;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\TypeSpeciesEntity|\App\Services\Entities\SpeciesEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->speciesRepository()->oneById($id);

        $SpeciesEntity = $this->speciesEntity()->create($Model);
        $this->setSpeciesEntity($SpeciesEntity);

        return $SpeciesEntity;
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $Collection = $this->speciesRepository()->manyByGenusId(reset($input));

        return $this->typeSpeciesEntity()->create($Collection);
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
     * @return mixed
     */
    public function add(...$input)
    {
        // TODO: Implement add() method.
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function edit(...$input)
    {
        $title = $input[0];
        $chineseTitle = $input[1];
        $description = $input[2];

        return $this->speciesRepository()->edit($this->SpeciesEntity->getId(), $title, $chineseTitle, $description);
    }

    /**
     * @param int   $dataId
     * @param array $input
     *
     * @return mixed
     */
    public function delete($dataId, ...$input)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param SpeciesEntity $SpeciesEntity
     */
    public function setSpeciesEntity($SpeciesEntity)
    {
        $this->SpeciesEntity = $SpeciesEntity;
    }

}