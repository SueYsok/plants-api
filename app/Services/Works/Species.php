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
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\TypeSpeciesEntity|\App\Services\Entities\SpeciesEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->speciesRepository()->oneById($id);

        return $this->speciesEntity()->create($Model);
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
     * @param mixed $input
     *
     * @return mixed
     */
    public function add(...$input)
    {
        // TODO: Implement add() method.
    }

    /**
     * @param int   $speciesId
     * @param mixed $input
     *
     * @return bool
     */
    public function edit($speciesId, ...$input)
    {
        $title = $input[0];
        $chineseTitle = $input[1];
        $description = $input[2];

        return $this->speciesRepository()->edit($speciesId, $title, $chineseTitle, $description);
    }

    /**
     * @param int   $dataId
     * @param mixed $input
     *
     * @return mixed
     */
    public function delete($dataId, ...$input)
    {
        // TODO: Implement delete() method.
    }

}