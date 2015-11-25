<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午3:34
 */

namespace App\Services\Entities;

use App\Eloquent\PlantsImages;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class PlantsImagesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class PlantsImagesEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $plantsId;
    /**
     * @var string
     */
    protected $image;
    /**
     * @var PlantsEntity
     */
    protected $plants;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return Entity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof PlantsImages) {
            foreach (['id', 'plants_id', 'image', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if (isset($Item->plants)) {
                $this->plants = (new PlantsEntity)->create($Item->plants);
            }

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
     * @return int
     */
    public function getPlantsId()
    {
        return $this->plantsId;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return PlantsEntity
     */
    public function getPlants()
    {
        return $this->plants;
    }

}