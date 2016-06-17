<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午5:00
 */

namespace App\Services\Entities;

use App\Eloquent\HybridsImages;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class HybridsImagesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class HybridsImagesEntity extends Entity
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $hybridsId;
    /**
     * @var string
     */
    protected $image;
    /**
     * @var HybridsEntity
     */
    protected $hybrids;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return HybridsImagesEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof HybridsImages) {
            foreach (['id', 'hybrids_id', 'image', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if ($Item->relationLoaded('hybrids')) {
                $this->hybrids = (new HybridsEntity)->create($Item->hybrids);
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
    public function getHybridsId()
    {
        return $this->hybridsId;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return HybridsEntity
     */
    public function getHybrids()
    {
        return $this->hybrids;
    }

}

