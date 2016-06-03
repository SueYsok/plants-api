<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/5
 * Time: 下午3:41
 */

namespace App\Services\Entities;

use App\Eloquent\BusinessesPlants;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class BusinessesPlantsEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class BusinessesPlantsEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $businessesId;
    /**
     * @var int
     */
    protected $plantsId;
    /**
     * @var string
     */
    protected $number;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var array
     */
    protected $price;
    /**
     * @var BusinessesEntity
     */
    protected $businesses;
    /**
     * @var PlantsEntity
     */
    protected $plants;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return BusinessesPlantsEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof BusinessesPlants) {
            foreach ([
                         'id',
                         'businesses_id',
                         'plants_id',
                         'number',
                         'description',
                         'created_at',
                         'updated_at',
                     ] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if ($Item->relationLoaded('price')) {
                $this->price = json_decode($Item->price, true);
            }

            if ($Item->relationLoaded('businesses')) {
                $this->businesses = (new BusinessesEntity)->create($Item->businesses);
            }

            if ($Item->relationLoaded('plants')) {
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
    public function getBusinessesId()
    {
        return $this->businessesId;
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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return BusinessesEntity
     */
    public function getBusinesses()
    {
        return $this->businesses;
    }

    /**
     * @return PlantsEntity
     */
    public function getPlants()
    {
        return $this->plants;
    }

}