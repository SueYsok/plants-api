<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/4
 * Time: 下午6:10
 */

namespace App\Services\Entities;

use App\Eloquent\Subspecies;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class SubspeciesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class SubspeciesEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $speciesId;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $chineseTitle;
    /**
     * @var TypeSpeciesEntity
     */
    protected $species;
    /**
     * @var PlantsEntity
     */
    protected $plants;
    /**
     * @var Collection
     */
    protected $varietas;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return SubspeciesEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Subspecies) {
            foreach (['id', 'species_id', 'title', 'chinese_title', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if ($Item->relationLoaded('species')) {
                $this->species = (new TypeSpeciesEntity)->create($Item->species);
            }

            if ($Item->relationLoaded('plants')) {
                $this->plants = (new PlantsEntity)->create($Item->plants);
            }

            $this->varietas = (new VarietasEntity)->create($Item->relationLoaded('varietas') ? $Item->varietas : null);

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
    public function getSpeciesId()
    {
        return $this->speciesId;
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
     * @return TypeSpeciesEntity
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * @return Collection
     */
    public function getVarietas()
    {
        return $this->varietas;
    }

    /**
     * @return PlantsEntity
     */
    public function getPlants()
    {
        return $this->plants;
    }

}