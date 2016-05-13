<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:18
 */

namespace App\Services\Repositories;


/**
 * Class GenusRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 */
class GenusRepository extends Repository
{

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Genus
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with('family')
            ->with('typeSpecies')
            ->with([
                'species' => function ($Model) {
                    /** @var \App\Eloquent\Genus $Model */
                    $Model
                        ->with('subspecies')
                        ->with('varietas');
                },
            ])
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param int $familyId
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyByFamilyId($familyId)
    {
        $Collection = $this->many(function ($Model) use ($familyId) {
            /** @var \App\Eloquent\Genus|\Illuminate\Database\Eloquent\Builder $Model */
            return $Model->where('family_id', '=', $familyId);
        });

        return $Collection;
    }

}