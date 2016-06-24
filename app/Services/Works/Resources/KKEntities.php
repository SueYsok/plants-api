<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/24
 * Time: 上午10:10
 */

namespace App\Services\Works\Resources;

use App\Services\Entities\KKSeedsChangesEntity;


/**
 * Trait KKEntities
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait KKEntities
{

    /**
     * @return KKSeedsChangesEntity
     */
    public function seedsChangesEntity()
    {
        return new KKSeedsChangesEntity;
    }

}