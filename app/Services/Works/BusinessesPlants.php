<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/20
 * Time: 下午5:59
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\BusinessesEntities;
use App\Services\Works\Resources\BusinessesRepositories;


/**
 * Class BusinessesPlants
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class BusinessesPlants implements Selection
{

    use BusinessesRepositories, BusinessesEntities;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return mixed
     */
    public function one($id, ...$input)
    {
        // TODO: Implement one() method.
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $Collection = $this->plantsRepository()->manyByBusinessesId(reset($input));

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