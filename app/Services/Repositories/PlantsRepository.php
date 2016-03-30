<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:20
 */

namespace App\Services\Repositories;

use App\Eloquent\Plants;
use Illuminate\Database\Eloquent\Builder;


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
            ->with('tags')
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
     * @param $id
     *
     * @return \App\Eloquent\Plants
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
     * @param array $query
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyByQuery(array $query)
    {
        $Model = $this->Model;
        if (isset($query['family_id'])) {
            $Model = $Model->where('family_id', '=', $query['family_id']);
        }
        if (isset($query['genus_id'])) {
            $Model = $Model->where('genus_id', '=', $query['genus_id']);
        }
        if (isset($query['species_id'])) {
            $Model = $Model->where('species_id', '=', $query['species_id']);
        }
        if (isset($query['subspecies_id'])) {
            $Model = $Model->where('subspecies_id', '=', $query['subspecies_id']);
        }
        if (isset($query['varietas_id'])) {
            $Model = $Model->where('varietas_id', '=', $query['varietas_id']);
        }
        if (isset($query['tags_id']) || isset($query['tags_title'])) {
            $Model = $this->tagsQuery($query, $Model);
        }
        if (isset($query['businesses_id'])) {
            $Model = $this->businessesQuery($query['businesses_id'], $Model);
        }

        return $Model->get();
    }

    /**
     * @param array          $query
     * @param Builder|Plants $Model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function tagsQuery(array $query, $Model)
    {
        return $Model->whereHas('tagslink', function ($Model) use ($query) {
            /** @var \App\Eloquent\TagsPlants|\Illuminate\Database\Eloquent\Builder $Model */
            if (isset($query['tags_id'])) {
                $Model->where('tags_id', '=', $query['tags_id']);
            } else {
                $Model->where('tags_title', '=', $query['tags_title']);
            }
        });
    }

    /**
     * @param int            $businessesId
     * @param Builder|Plants $Model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function businessesQuery($businessesId, $Model)
    {
        return $Model->whereHas('businesseslink', function ($Model) use ($businessesId) {
            /** @var \App\Eloquent\BusinessesPlants|\Illuminate\Database\Eloquent\Builder $Model */
            $Model->where('businesses_id', '=', $businessesId);
        });
    }

}