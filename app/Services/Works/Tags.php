<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:04
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\TagsEntities;
use App\Services\Works\Resources\TagsRepositories;


/**
 * Class Tags
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Tags extends Work implements Selection
{

    use TagsRepositories, TagsEntities;


    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\TagsEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->tagsRepository()->oneById($id);

        return $this->tagsEntity()->create($Model);
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $Collection = $this->tagsRepository()->many();

        return $this->tagsEntity()->create($Collection);
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