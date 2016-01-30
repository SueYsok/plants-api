<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/5
 * Time: 下午3:50
 */

namespace App\Services\Entities;

use App\Eloquent\Plants;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class PlantsEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class PlantsEntity extends Entity
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
    protected $description;
    /**
     * @var string
     */
    protected $cover;
    /**
     * @var int
     */
    protected $familyId;
    /**
     * @var int
     */
    protected $genusId;
    /**
     * @var int
     */
    protected $speciesId;
    /**
     * @var int
     */
    protected $subspeciesId;
    /**
     * @var int
     */
    protected $varietasId;
    /**
     * @var FamilyEntity
     */
    protected $family;
    /**
     * @var GenusEntity
     */
    protected $genus;
    /**
     * @var TypeSpeciesEntity
     */
    protected $species;
    /**
     * @var SubspeciesEntity
     */
    protected $subspecies;
    /**
     * @var VarietasEntity
     */
    protected $varietas;
    /**
     * @var Collection
     */
    protected $images;
    /**
     * @var Collection
     */
    protected $plants;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return Entity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Plants) {
            foreach ([
                         'id',
                         'title',
                         'description',
                         'cover',
                         'family_id',
                         'genus_id',
                         'species_id',
                         'subspecies_id',
                         'varietas_id',
                         'created_at',
                         'updated_at',
                     ] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if (isset($Item->family)) {
                $this->family = (new FamilyEntity)->create($Item->family);
            }

            if (isset($Item->genus)) {
                $this->genus = (new GenusEntity)->create($Item->genus);
            }

            if (isset($Item->species)) {
                $this->species = (new TypeSpeciesEntity)->create($Item->species);
            }

            if (isset($Item->subspecies)) {
                $this->subspecies = (new SubspeciesEntity)->create($Item->subspecies);
            }

            if (isset($Item->varietas)) {
                $this->varietas = (new VarietasEntity)->create($Item->varietas);
            }

            if (isset($Item->images)) {
                $this->images = (new PlantsImagesEntity)->create($Item->images);
            }

            if (isset($Item->same)) {
                $SameCollection = new ModelCollection;

                /** @var \App\Eloquent\PlantsSame $Same */
                foreach ($Item->same->same as $Same) {
                    $SameCollection->push($Same->plant);
                }
                $this->plants = (new self)->create($SameCollection);
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
    public function getFamilyId()
    {
        return $this->familyId;
    }

    /**
     * @return int
     */
    public function getGenusId()
    {
        return $this->genusId;
    }

    /**
     * @return int
     */
    public function getSpeciesId()
    {
        return $this->speciesId;
    }

    /**
     * @return int
     */
    public function getSubspeciesId()
    {
        return $this->subspeciesId;
    }

    /**
     * @return int
     */
    public function getVarietasId()
    {
        return $this->varietasId;
    }

    /**
     * @return FamilyEntity
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @return GenusEntity
     */
    public function getGenus()
    {
        return $this->genus;
    }

    /**
     * @return TypeSpeciesEntity
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * @return SubspeciesEntity
     */
    public function getSubspecies()
    {
        return $this->subspecies;
    }

    /**
     * @return VarietasEntity
     */
    public function getVarietas()
    {
        return $this->varietas;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Collection
     */
    public function getPlants()
    {
        return $this->plants;
    }

}