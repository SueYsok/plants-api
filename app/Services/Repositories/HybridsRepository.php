<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午1:38
 */

namespace App\Services\Repositories;


/**
 * Class HybridsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class HybridsRepository extends Repository
{

    /**
     * @param $id
     *
     * @return \App\Eloquent\Hybrids
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with('leftplants')
            ->with('rightplants')
            ->with('images')
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param array $query
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyByQuery(array $query)
    {
        $Model = $this->Model;
        if (isset($query['1_plants_id']) && !isset($query['2_plants_id'])) {
            $Model = $Model
                ->where('left_plants_id', '=', $query['1_plants_id'])
                ->orWhere('right_plants_id', '=', $query['1_plants_id']);
        }
        if (!isset($query['1_plants_id']) && isset($query['2_plants_id'])) {
            $Model = $Model
                ->where('left_plants_id', '=', $query['2_plants_id'])
                ->orWhere('right_plants_id', '=', $query['2_plants_id']);
        }
        if (isset($query['1_plants_id']) && isset($query['2_plants_id'])) {
            $Model = $Model
                ->where(function ($Model) use ($query) {
                    /** @var \Illuminate\Database\Eloquent\Builder $Model */
                    $Model->where('left_plants_id', '=', $query['1_plants_id'])
                        ->where('right_plants_id', '=', $query['2_plants_id']);
                })
                ->orWhere(function ($Model) use ($query) {
                    /** @var \Illuminate\Database\Eloquent\Builder $Model */
                    $Model->where('left_plants_id', '=', $query['2_plants_id'])
                        ->where('right_plants_id', '=', $query['1_plants_id']);
                });
        }

        return $Model
            ->with('leftplants')
            ->with('rightplants')
            ->get();
    }

}