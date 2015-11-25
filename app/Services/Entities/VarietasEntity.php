<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/4
 * Time: 下午6:17
 */

namespace App\Services\Entities;

use App\Eloquent\Varietas;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class VarietasEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class VarietasEntity extends Entity
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
     * @var int
     */
    protected $subspeciesId;
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
     * @var SubspeciesEntity
     */
    protected $subspecies;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return Entity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Varietas) {
            foreach ([
                         'id',
                         'species_id',
                         'subspecies_id',
                         'title',
                         'chinese_title',
                         'created_at',
                         'updated_at',
                     ] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if (isset($Item->species)) {
                $this->species = (new TypeSpeciesEntity)->create($Item->species);
            }

            if (isset($Item->subspecies)) {
                $this->subspecies = (new SubspeciesEntity)->create($Item->subspecies);
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
     * @return SubspeciesEntity
     */
    public function getSubspecies()
    {
        return $this->subspecies;
    }

}