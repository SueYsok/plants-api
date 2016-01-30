<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:20
 */

namespace App\Services\Repositories;


/**
 * Class PlantsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class PlantsRepository extends Repository
{

    /**
     * @param $id
     *
     * @return \App\Eloquent\Plants
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with('family')
            ->with('genus')
            ->with('species')
            ->with('subspecies')
            ->with('varietas')
            ->with('images')
            ->with([
                'same' => function ($Model) {
                    /** @var \App\Eloquent\PlantsSame $Model */
                    $Model->with([
                        'same' => function ($Model) {
                            /** @var \App\Eloquent\PlantsSame $Model */
                            $Model->with('plant');
                        },
                    ]);
                },
            ])
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
        $Collection = $this->many(function ($Model) use ($query) {
            /** @var \App\Eloquent\Plants|\Illuminate\Database\Eloquent\Builder $Model */
            foreach ($query as $key => $value) {
                if ($value) {
                    $Model = $Model->where($key, '=', $value);
                }
            }

            return $Model;
        });

        return $Collection;
    }

}