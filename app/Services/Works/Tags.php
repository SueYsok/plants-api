<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:04
 */

namespace App\Services\Works;

use App\Services\Contracts\Selection;
use App\Services\Works\Resources\TagsEntities;
use App\Services\Works\Resources\TagsRepositories;
use Illuminate\Support\Collection;


/**
 * Class Tags
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Tags extends Work implements Selection
{

    use TagsRepositories, TagsEntities;


    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return \App\Services\Entities\TagsEntity
     */
    public function one($id, ...$input)
    {
        $Model = $this->tagsRepository()->oneById($id);

        return $this->tagsEntity()->create($Model);
    }

    /**
     * @param mixed $input
     *
     * @return \Illuminate\Support\Collection
     */
    public function many(...$input)
    {
        $queries = [];
        if (isset($input[0])) {
            $queries['title'] = $input[0];
        }
        if (isset($input[1])) {
            $queries['id'] = $input[1];
        }
        $Collection = $this->tagsRepository()->manyByBaseQueries($queries);

        return $this->tagsEntity()->create($Collection);
    }

    /**
     * @param mixed $index
     *
     * @return int
     */
    public function id($index)
    {
        // TODO: Implement id() method.
    }

    /**
     * @param array $tagTitles
     * @param int   $userId
     *
     * @return \Illuminate\Support\Collection
     */
    public function addMany(array $tagTitles, $userId)
    {
        $Collection = $this->tagsRepository()->addMany($tagTitles, $userId);

        return $this->tagsEntity()->create($Collection);
    }

    /**
     * @param array $tagsIds
     */
    public function incMany(array $tagsIds)
    {
        $this->tagsRepository()->incByTagsIds($tagsIds);
    }

    /**
     * @param array $tagsIds
     */
    public function decMany(array $tagsIds)
    {
        $this->tagsRepository()->decByTagsIds($tagsIds);
    }

    /**
     * @param array $tagsIds
     * @param array $tagsTitles
     * @param int   $userId
     *
     * @return Collection
     */
    public function addNoDuplicates($tagsIds, $tagsTitles, $userId)
    {
        if ($tagsTitles) {
            $TagsCollection1 = $this->many($tagsTitles);
        }
        if ($tagsIds) {
            $TagsCollection2 = $this->many(null, $tagsIds);
        }
        if (isset($TagsCollection1) && isset($TagsCollection2)) {
            $TagsCollection = $TagsCollection1->merge($TagsCollection2)->union('id');
        } else {
            $TagsCollection = isset($TagsCollection1) ? $TagsCollection1
                : (isset($TagsCollection2) ? $TagsCollection2 : new Collection);
        }

        //剔除已存在的标签名
        if ($tagsTitles && $TagsCollection) {
            foreach ($tagsTitles as $key => $tagsTitle) {
                /** @var \App\Services\Entities\TagsEntity $TagsEntity */
                foreach ($TagsCollection as $TagsEntity) {
                    if ($TagsEntity->getTitle() == $tagsTitle) {
                        unset($tagsTitles[$key]);
                        continue 2;
                    }
                }
            }
        }

        if (!empty($tagsTitles)) {
            $TagsCollection3 = $this->tagsEntity()->create($this->Tags->addMany($tagsTitles, $userId));
            $TagsCollection = $TagsCollection3->merge($TagsCollection)->union('id');
        }

        return $TagsCollection;
    }

}