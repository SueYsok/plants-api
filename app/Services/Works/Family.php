<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午3:24
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;


/**
 * Class Family
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Family extends Work implements Selection
{

    use PlantsRepositories, PlantsEntities;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\FamilyEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->familyRepository()->oneById($id);

        return $this->familyEntity()->create($Model);
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $Collection = $this->familyRepository()->many();

        return $this->familyEntity()->create($Collection);
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