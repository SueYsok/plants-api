<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:20
 */

namespace App\Services\Repositories;


/**
 * Class PlantsImagesRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\PlantsImages|\Illuminate\Database\Eloquent\Builder Model
 */
class PlantsImagesRepository extends Repository
{

    /**
     * @param int    $plantsId
     * @param int    $userId
     * @param string $image
     *
     * @return \App\Eloquent\PlantsImages
     */
    public function add($plantsId, $userId, $image)
    {
        $this->Model->plants_id = $plantsId;
        $this->Model->user_id = $userId;
        $this->Model->image = $image;
        $this->Model->save();

        return $this->Model;
    }

    /**
     * @param int $id
     *
     * @return \App\Eloquent\PlantsImages
     */
    public function oneSimpleById($id)
    {
        $Model = $this->Model->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param int $id
     */
    public function destroy($id)
    {
        $this->Model->destroy($id);
    }

}