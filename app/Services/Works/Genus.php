<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午1:56
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;


/**
 * Class Genus
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Genus implements Selection
{

    use PlantsRepositories, PlantsEntities;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\GenusEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->genusRepository()->oneById($id);

        return $this->genusEntity()->create($Model);
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $Collection = $this->genusRepository()->manyByFamilyId(reset($input));

        return $this->genusEntity()->create($Collection);
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

}