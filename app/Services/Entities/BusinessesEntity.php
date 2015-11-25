<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/5
 * Time: 下午3:37
 */

namespace App\Services\Entities;

use App\Eloquent\Businesses;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class BusinessesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class BusinessesEntity extends Entity
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
    protected $webSite;
    /**
     * @var string
     */
    protected $country;
    /**
     * @var string
     */
    protected $description;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return BusinessesEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Businesses) {
            foreach (['id', 'title', 'web_site', 'country', 'description', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}