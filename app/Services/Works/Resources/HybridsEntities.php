<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午4:59
 */

namespace App\Services\Works\Resources;

use App\Services\Entities\HybridsEntity;
use App\Services\Entities\HybridsImagesEntity;


/**
 * Trait HybridsEntities
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait HybridsEntities
{

    /**
     * @return HybridsEntity
     */
    public function hybridsEntity()
    {
        return new HybridsEntity;
    }

    /**
     * @return HybridsImagesEntity
     */
    protected function hybridsImagesEntity()
    {
        return new HybridsImagesEntity;
    }

}