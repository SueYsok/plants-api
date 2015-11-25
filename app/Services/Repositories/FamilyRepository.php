<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:18
 */

namespace App\Services\Repositories;


/**
 * Class FamilyRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class FamilyRepository extends Repository
{

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Family
     */
    public function oneById($id)
    {
        $Model = $this->Model->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

}