<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:19
 */

namespace App\Services\Repositories;


/**
 * Class SpeciesRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class SpeciesRepository extends Repository
{

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Species
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with([
                'genus' => function ($Model) {
                    /** @var \App\Eloquent\Genus $Model */
                    $Model->with('family');
                },
            ])
            ->with('subspecies')
            ->with('varietas')
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Species
     */
    public function oneWithSupById($id)
    {
        $Model = $this->Model
            ->with([
                'genus' => function ($Model) {
                    /** @var \App\Eloquent\Genus $Model */
                    $Model->with('family');
                },
            ])
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Species
     */
    public function oneWithInfById($id)
    {
        $Model = $this->Model
            ->with('subspecies')
            ->with('varietas')
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param int $genusId
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyByGenusId($genusId)
    {
        $Collection = $this->many(function ($Model) use ($genusId) {
            /** @var \App\Eloquent\Species|\Illuminate\Database\Eloquent\Builder $Model */
            return $Model->where('genus_id', '=', $genusId);
        });

        return $Collection;
    }

}