<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午6:14
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;


/**
 * Class Species
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Species implements Selection
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
        if (reset($input)) {
            return $this->supraspecificBranch($id);
        } else {
            return $this->infraspecificBranch($id);
        }
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
     * @param $id
     *
     * @return \App\Services\Entities\TypeSpeciesEntity
     */
    private function supraspecificBranch($id)
    {
        $Model = $this->speciesRepository()->oneWithSupById($id);

        return $this->typeSpeciesEntity()->create($Model);
    }

    /**
     * @param $id
     *
     * @return \App\Services\Entities\SpeciesEntity
     */
    private function infraspecificBranch($id)
    {
        $Model = $this->speciesRepository()->oneWithInfById($id);

        return $this->speciesEntity()->create($Model);
    }

}