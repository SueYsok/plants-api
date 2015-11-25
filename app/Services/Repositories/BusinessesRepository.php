<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:17
 */

namespace App\Services\Repositories;


/**
 * Class BusinessesRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class BusinessesRepository extends Repository
{

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Businesses
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