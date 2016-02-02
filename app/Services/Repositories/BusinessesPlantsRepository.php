<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:17
 */

namespace App\Services\Repositories;


/**
 * Class BusinessesPlantsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class BusinessesPlantsRepository extends Repository
{

    /**
     * @param $businessesId
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyByBusinessesId($businessesId)
    {
        $Collection = $this->many(function ($Model) use ($businessesId) {
            /** @var \App\Eloquent\BusinessesPlants|\Illuminate\Database\Eloquent\Builder $Model */
            return $Model
                ->with('plants')
                ->where('businesses_id', '=', $businessesId)
                ->orderBy('number');
        });

        return $Collection;
    }

}