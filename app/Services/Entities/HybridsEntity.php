<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午2:03
 */

namespace App\Services\Entities;

use App\Eloquent\Hybrids;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class HybridsEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class HybridsEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $alias;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $content;
    /**
     * @var string
     */
    protected $cover;
    /**
     * @var int
     */
    protected $coversId;
    /**
     * @var int
     */
    protected $leftPlantsId;
    /**
     * @var int
     */
    protected $rightPlantsId;
    /**
     * @var int
     */
    protected $userId;
    /**
     * @var PlantsEntity
     */
    protected $leftPlants;
    /**
     * @var PlantsEntity
     */
    protected $rightPlants;
    /**
     * @var Collection
     */
    protected $images;
    /**
     * @var Collection
     */
    protected $tags;
    /**
     * @var Collection
     */
    protected $covers;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return HybridsEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Hybrids) {
            foreach ([
                         'id',
                         'title',
                         'alias',
                         'description',
                         'content',
                         'covers_id',
                         'left_plants_id',
                         'right_plants_id',
                         'user_id',
                         'created_at',
                         'updated_at',
                     ] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if ($Item->relationLoaded('cover') && $Item->cover) {
                $this->cover = $Item->cover->image;
            }

            if ($Item->relationLoaded('covers')) {
                $this->covers = $Item->covers;
            }

            if ($Item->relationLoaded('leftplants')) {
                $this->leftPlants = (new PlantsEntity)->create($Item->leftplants);
            }

            if ($Item->relationLoaded('rightplants')) {
                $this->rightPlants = (new PlantsEntity)->create($Item->rightplants);
            }

            $this->images = (new HybridsImagesEntity)->create($Item->relationLoaded('images') ? $Item->images : null);

            $this->tags = (new TagsEntity)->create($Item->relationLoaded('tags') ? $Item->tags : null);

            return $this;
        } else {
            $this->setCollection($Item);

            return $this->Collection;
        }
    }

    /**
     * @return Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @return int
     */
    public function getLeftPlantsId()
    {
        return $this->leftPlantsId;
    }

    /**
     * @return int
     */
    public function getRightPlantsId()
    {
        return $this->rightPlantsId;
    }

    /**
     * @return PlantsEntity
     */
    public function getLeftPlants()
    {
        return $this->leftPlants;
    }

    /**
     * @return PlantsEntity
     */
    public function getRightPlants()
    {
        return $this->rightPlants;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getCoversId()
    {
        return $this->coversId;
    }

    /**
     * @return Collection
     */
    public function getCovers()
    {
        return $this->covers;
    }

}