<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午3:16
 */

namespace App\Services\Entities;

use App\Eloquent\Family;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class FamilyEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class FamilyEntity extends Entity
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
    protected $chineseTitle;
    /**
     * @var Collection
     */
    protected $genus;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return FamilyEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Family) {
            foreach (['id', 'title', 'chinese_title', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            $this->genus = (new GenusEntity)->create($Item->relationLoaded('genus') ? $Item->genus : null);

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
     * @return string
     */
    public function getChineseTitle()
    {
        return $this->chineseTitle;
    }

    /**
     * @return Collection
     */
    public function getGenus()
    {
        return $this->genus;
    }

}