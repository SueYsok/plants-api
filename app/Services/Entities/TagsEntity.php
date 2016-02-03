<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/1/31
 * Time: 上午1:43
 */

namespace App\Services\Entities;

use App\Eloquent\Tags;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class TagsEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class TagsEntity extends Entity
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
     * @var int
     */
    protected $count;
    /**
     * @var Collection
     */
    protected $plants;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return TagsEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Tags) {
            foreach (['id', 'title', 'count', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            $this->plants = (new PlantsEntity)->create(isset($Item->plants) ? $Item->plants : null);

            return $this;
        } else {
            $this->setCollection($Item);

            return $this->Collection;
        }
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
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return Collection
     */
    public function getPlants()
    {
        return $this->plants;
    }

}