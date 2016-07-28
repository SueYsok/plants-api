<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/7/6
 * Time: 上午11:54
 */

namespace App\Services\Repositories;


/**
 * Class PlantsCoversRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\plantsCovers|\Illuminate\Database\Eloquent\Builder Model
 */
class PlantsCoversRepository extends Repository
{

    /**
     * @param int    $plantsId
     * @param int    $userId
     * @param string $image
     *
     * @return \App\Eloquent\PlantsCovers
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
     * @return \App\Eloquent\PlantsCovers
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