<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:51
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;


/**
 * Class Plants
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Plants extends Work implements Selection
{

    use PlantsRepositories, PlantsEntities;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\PlantsEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->plantsRepository()->oneById($id);

        return $this->plantsEntity()->create($Model);
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
            $query['businesses_id'] = $input[6];
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

}