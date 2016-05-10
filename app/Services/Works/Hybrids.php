<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午4:58
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\HybridsEntities;
use App\Services\Works\Resources\HybridsRepositories;


/**
 * Class Hybrids
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Hybrids extends Work implements Selection
{

    use HybridsRepositories, HybridsEntities;

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return mixed
     */
    public function one($id, ...$input)
    {
        $Model = $this->hybridsRepository()->oneById($id);

        return $this->hybridsEntity()->create($Model);
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
}