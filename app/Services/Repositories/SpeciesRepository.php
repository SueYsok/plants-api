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
            ->with([
                'subspecies' => function ($Model) {
                    /** @var \App\Eloquent\Genus $Model */
                    $Model->with([
                        'plants' => function ($Model) {
                            /** @var \App\Eloquent\Plants $Model */
                            $Model->with('cover');
                        },
                    ]);
                },
            ])
            ->with([
                'varietas' => function ($Model) {
                    /** @var \App\Eloquent\Genus $Model */
                    $Model->with([
                        'plants' => function ($Model) {
                            /** @var \App\Eloquent\Plants $Model */
                            $Model->with('cover');
                        },
                    ]);
                },
            ])
            ->with([
                'plants' => function ($Model) {
                    /** @var \App\Eloquent\Plants $Model */
                    $Model->with('cover');
                },
            ])
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

    /**
     * @param int    $speciesId
     * @param string $title
     * @param string $chineseTitle
     * @param string $description
     *
     * @return bool
     */
    public function edit($speciesId, $title, $chineseTitle, $description)
    {
        /** @var \App\Eloquent\Species $Model */
        $Model = $this->Model->find($speciesId);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        $Model->title = $title;
        $Model->chinese_title = $chineseTitle;
        $Model->description = $description;

        return $Model->save();
    }

}