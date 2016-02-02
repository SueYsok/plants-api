<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:55
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\BusinessesEntities;
use App\Services\Works\Resources\BusinessesRepositories;


/**
 * Class Businesses
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Businesses extends Work implements Selection
{

    use BusinessesRepositories, BusinessesEntities;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\BusinessesEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->businessesRepository()->oneById($id);

        return $this->businessesEntity()->create($Model);
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $Collection = $this->businessesRepository()->many();

        return $this->businessesEntity()->create($Collection);
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