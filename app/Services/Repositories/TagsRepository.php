<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:10
 */

namespace App\Services\Repositories;


/**
 * Class TagsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class TagsRepository extends Repository
{

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Tags
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with('plants')
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

}