<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午1:38
 */

namespace App\Services\Repositories;

use App\Eloquent\Hybrids;
use App\Eloquent\Tags;
use App\Eloquent\TagsHybrids;


/**
 * Class HybridsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\Hybrids|\Illuminate\Database\Eloquent\Builder Model
 */
class HybridsRepository extends Repository
{

    /**
     * @param string      $title
     * @param string|null $alias
     * @param string|null $description
     * @param string|null $content
     * @param int|null    $coversId
     * @param int|null    $leftPlantsIds
     * @param int|null    $rightPlantsIds
     * @param array|null  $tagsIds
     * @param int         $userId
     *
     * @return \App\Eloquent\Hybrids|\Illuminate\Database\Eloquent\Builder
     */
    public function add(
        $title,
        $alias,
        $description,
        $content,
        $coversId,
        $leftPlantsIds,
        $rightPlantsIds,
        $tagsIds,
        $userId
    ) {
        $this->Model->title = $title;
        $this->Model->alias = $alias ?: null;
        $this->Model->description = $description ?: null;
        $this->Model->content = $content ?: null;
        $this->Model->covers_id = $coversId ?: null;
        $this->Model->left_plants_id = $leftPlantsIds;
        $this->Model->right_plants_id = $rightPlantsIds;
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
     * @param int|null    $coversId
     * @param int|null    $leftPlantsIds
     * @param int|null    $rightPlantsIds
     * @param array|null  $tagsIds
     *
     * @return Hybrids
     */
    public function edit(
        $id,
        $title,
        $alias,
        $description,
        $content,
        $coversId,
        $leftPlantsIds,
        $rightPlantsIds,
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
        $this->Model->covers_id = $coversId ?: null;
        $this->Model->left_plants_id = $leftPlantsIds;
        $this->Model->right_plants_id = $rightPlantsIds;

        $this->Model->save();

        if (!$this->Model->tagslink->isEmpty()) {
            /** @var \App\Eloquent\TagsHybrids $TagsHybridsModel */
            foreach ($this->Model->tagslink->all() as $TagsHybridsModel) {
                if (!in_array($TagsHybridsModel->tags_id, $tagsIds)) {
                    $TagsHybridsModel->delete();
                    continue;
                }
                foreach ($tagsIds as $key => $tagsId) {
                    if ($tagsId == $TagsHybridsModel->tags_id) {
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

        if ($Model instanceof Hybrids) {
            if (!$Model->tagslink->isEmpty()) {
                /** @var \App\Eloquent\TagsPlants $TagsHybridsModel */
                foreach ($Model->tagslink->all() as $TagsHybridsModel) {
                    $TagsHybridsModel->delete();
                }
            }
            $Model->delete();
        }
    }

    /**
     * @param $id
     *
     * @return \App\Eloquent\Hybrids|\Illuminate\Database\Eloquent\Builder
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with('cover')
            ->with('leftplants')
            ->with('rightplants')
            ->with('images')
            ->with('tags')
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
            ->with('cover')
            ->with('leftplants')
            ->with('rightplants')
            ->get();
    }

    /**
     * @param int $coversId
     */
    public function resetCoversId($coversId)
    {
        $Collection = $this->Model->where('covers_id', $coversId)->get();

        /** @var \App\Eloquent\Hybrids $Model */
        foreach ($Collection->all() as $Model) {
            $Model->covers_id = null;
            $Model->save();
        }
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
            array_push($tagsLinkModels, new TagsHybrids([
                'tags_id'    => $TagsModel->id,
                'hybrids_id' => $this->Model->id,
                'tags_title' => $TagsModel->title,
            ]));
        }
        $this->Model->tagslink()->saveMany($tagsLinkModels);
    }

}