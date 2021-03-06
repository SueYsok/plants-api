<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午1:41
 */

namespace App\Services\Repositories;


/**
 * Class HybridsImagesRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\HybridsImages|\Illuminate\Database\Eloquent\Builder Model
 */
class HybridsImagesRepository extends Repository
{

    /**
     * @param int    $hybridsId
     * @param int    $userId
     * @param string $image
     *
     * @return \App\Eloquent\HybridsImages
     */
    public function add($hybridsId, $userId, $image)
    {
        $this->Model->hybrids_id = $hybridsId;
        $this->Model->user_id = $userId;
        $this->Model->image = $image;
        $this->Model->save();

        return $this->Model;
    }

    /**
     * @param int $id
     *
     * @return \App\Eloquent\HybridsImages
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