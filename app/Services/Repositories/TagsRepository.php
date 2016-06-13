<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:10
 */

namespace App\Services\Repositories;

use App\Eloquent\Tags;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class TagsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\Tags|\Illuminate\Database\Eloquent\Builder Model
 */
class TagsRepository extends Repository
{

    /**
     * @param $titles
     * @param $userId
     *
     * @return Collection
     */
    public function addMany($titles, $userId)
    {
        $Collection = new Collection;
        foreach ($titles as $title) {
            $Tags = new Tags;
            $Tags->user_id = $userId;
            $Tags->title = $title;
            $Tags->count = 0;
            $Tags->save();

            $Collection->push($Tags);
        }

        return $Collection;
    }

    /**
     * @param int $id
     *
     * @return \App\Eloquent\Tags
     */
    public function oneById($id)
    {
        $Model = $this->Model
            ->with([
                'plants' => function ($Model) {
                    /** @var \App\Eloquent\Plants $Model */
                    $Model
                        ->orderBy('title')
                        ->with('family')
                        ->with('genus')
                        ->with('species')
                        ->with('subspecies')
                        ->with('varietas')
                        ->with('tags');
                },
            ])
            ->find($id);
        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param array $tagsIds
     */
    public function incByTagsIds(array $tagsIds)
    {
        $this->Model->whereIn('id', $tagsIds)->increment('count');
    }

    /**
     * @param array $tagsIds
     */
    public function decByTagsIds(array $tagsIds)
    {
        $this->Model->whereIn('id', $tagsIds)->decrement('count');
    }

}