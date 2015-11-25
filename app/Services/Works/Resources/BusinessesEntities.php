<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:14
 */

namespace App\Services\Works\Resources;

use App\Services\Entities\BusinessesEntity;
use App\Services\Entities\BusinessesPlantsEntity;


/**
 * Trait BusinessesEntities
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait BusinessesEntities
{

    /**
     * @return BusinessesEntity
     */
    protected function businessesEntity()
    {
        return new BusinessesEntity;
    }

    /**
     * @return BusinessesPlantsEntity
     */
    protected function plantsEntity()
    {
        return new BusinessesPlantsEntity;
    }

}