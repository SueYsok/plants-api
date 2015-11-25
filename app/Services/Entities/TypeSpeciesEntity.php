<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/4
 * Time: 下午6:00
 */

namespace App\Services\Entities;

use App\Eloquent\Species;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class TypeSpeciesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class TypeSpeciesEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $genusId;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $chineseTitle;
    /**
     * @var boolean
     */
    protected $subProcess;
    /**
     * @var GenusEntity
     */
    protected $genus;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return TypeSpeciesEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Species) {
            foreach (['id', 'genus_id', 'title', 'chinese_title', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if (isset($Item->sub_process)) {
                $this->subProcess = $Item->sub_process ? true : false;
            }

            if (isset($Item->genus)) {
                $this->genus = (new GenusEntity)->create($Item->genus);
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
    public function getGenusId()
    {
        return $this->genusId;
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
     * @return boolean
     */
    public function getSubProcess()
    {
        return $this->subProcess;
    }

    /**
     * @return GenusEntity
     */
    public function getGenus()
    {
        return $this->genus;
    }

}