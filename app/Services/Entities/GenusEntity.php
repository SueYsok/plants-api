<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午6:00
 */

namespace App\Services\Entities;

use App\Eloquent\Genus;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class GenusEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class GenusEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $familyId;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $chineseTitle;
    /**
     * @var int|null
     */
    protected $typeSpeciesId;
    /**
     * @var FamilyEntity
     */
    protected $family;
    /**
     * @var TypeSpeciesEntity
     */
    protected $typeSpecies;
    /**
     * @var Collection
     */
    protected $species;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return GenusEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Genus) {
            foreach ([
                         'id',
                         'family_id',
                         'title',
                         'chinese_title',
                         'created_at',
                         'updated_at',
                     ] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }
            if (isset($Item['species_id'])) {
                $this->typeSpeciesId = $Item['species_id'];
            }

            if (isset($Item->family)) {
                $this->family = (new FamilyEntity)->create($Item->family);
            }

            if (isset($Item->typeSpecies)) {
                $this->typeSpecies = (new TypeSpeciesEntity)->create($Item->typeSpecies);
            }

            $this->species = (new TypeSpeciesEntity)->create($Item->species);

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
    public function getFamilyId()
    {
        return $this->familyId;
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
     * @return int|null
     */
    public function getTypeSpeciesId()
    {
        return $this->typeSpeciesId;
    }

    /**
     * @return FamilyEntity
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @return TypeSpeciesEntity
     */
    public function getTypeSpecies()
    {
        return $this->typeSpecies;
    }

    /**
     * @return Collection
     */
    public function getSpecies()
    {
        return $this->species;
    }

}