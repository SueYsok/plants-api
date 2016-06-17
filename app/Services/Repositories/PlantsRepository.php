<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:20
 */

namespace App\Services\Repositories;

use App\Eloquent\Plants;
use App\Eloquent\Tags;
use App\Eloquent\TagsPlants;
use Illuminate\Database\Eloquent\Builder;


/**
 * Class PlantsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\Plants|\Illuminate\Database\Eloquent\Builder Model
 */
class PlantsRepository extends Repository
{

    /**
     * @param string      $title
     * @param string|null $alias
     * @param string|null $description
     * @param string|null $content
     * @param string|null $cover
     * @param int         $familyId
     * @param int         $genusId
     * @param int         $speciesId
     * @param int|null    $subspeciesId
     * @param int|null    $varietasId
     * @param array       $tagsIds
     * @param int         $userId
     *
     * @return Plants|Builder
     */
    public function add(
        $title,
        $alias,
        $description,
        $content,
        $cover,
        $familyId,
        $genusId,
        $speciesId,
        $subspeciesId,
        $varietasId,
        $tagsIds,
        $userId
    ) {
        $this->Model->title = $title;
        $this->Model->alias = $alias ?: null;
        $this->Model->description = $description ?: null;
        $this->Model->content = $content ?: null;
        $this->Model->cover = $cover ?: null;
        $this->Model->family_id = $familyId;
        $this->Model->genus_id = $genusId;
        $this->Model->species_id = $speciesId;
        $this->Model->subspecies_id = $subspeciesId ?: null;
        $this->Model->varietas_id = $varietasId ?: null;
        $this->Model->user_id = $userId;

        $this->Model->save();

        $this->saveTagsLink($tagsIds);

        return $this->Model;
    }

    /**
     * @param int         $id
     * @param string      $title
     * @param string|null $alias
     * @param string|null $description
     * @param string|null $content
     * @param string|null $cover
     * @param int         $familyId
     * @param int         $genusId
     * @param int         $speciesId
     * @param int|null    $subspeciesId
     * @param int|null    $varietasId
     * @param array       $tagsIds
     *
     * @return Plants|Builder
     */
    public function edit(
        $id,
        $title,
        $alias,
        $description,
        $content,
        $cover,
        $familyId,
        $genusId,
        $speciesId,
        $subspeciesId,
        $varietasId,
        $tagsIds
    ) {
        $this->Model = $this->Model
            ->with('tagslink')
            ->find($id);

        if (is_null($this->Model)) {
            $this->modelNotFound();
        }

        $this->Model->title = $title;
        $this->Model->alias = $alias ?: null;
        $this->Model->description = $description ?: null;
        $this->Model->content = $content ?: null;
        $this->Model->cover = $cover ?: null;
        $this->Model->family_id = $familyId;
        $this->Model->genus_id = $genusId;
        $this->Model->species_id = $speciesId;
        $this->Model->subspecies_id = $subspeciesId ?: null;
        $this->Model->varietas_id = $varietasId ?: null;

        $this->Model->save();

        if (!$this->Model->tagslink->isEmpty()) {
            /** @var \App\Eloquent\TagsPlants $TagsPlantsModel */
            foreach ($this->Model->tagslink->all() as $TagsPlantsModel) {
                if (!in_array($TagsPlantsModel->tags_id, $tagsIds)) {
                    $TagsPlantsModel->delete();
                    continue;
                }
                foreach ($tagsIds as $key => $tagsId) {
                    if ($tagsId == $TagsPlantsModel->tags_id) {
                        unset($tagsIds[$key]);
                    }
                }
            }
        }

        $this->saveTagsLink($tagsIds);

        return $this->Model;
    }

    /**
     * @param int $id
     */
    public function deleteById($id)
    {
        $Model = $this->Model
            ->with('tagslink')
            ->find($id);

        if ($Model instanceof Plants) {
            if (!$Model->tagslink->isEmpty()) {
                /** @var \App\Eloquent\TagsPlants $TagsPlantsModel */
                foreach ($Model->tagslink->all() as $TagsPlantsModel) {
                    $TagsPlantsModel->delete();
                }
            }
            $Model->delete();
        }
    }

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

        return $Model
            ->with('family')
            ->with('genus')
            ->with('species')
            ->with('subspecies')
            ->with('varietas')
            ->with('tags')
            ->get();
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

    /**
     * @param array $tagsIds
     */
    private function saveTagsLink(array $tagsIds)
    {
        $tagsLinkModels = [];
        $TagsCollection = Tags::whereIn('id', $tagsIds)->get();
        /** @var \App\Eloquent\Tags $TagsModel */
        foreach ($TagsCollection as $TagsModel) {
            array_push($tagsLinkModels, new TagsPlants([
                'tags_id'    => $TagsModel->id,
                'plants_id'  => $this->Model->id,
                'tags_title' => $TagsModel->title,
            ]));
        }
        $this->Model->tagslink()->saveMany($tagsLinkModels);
    }

}