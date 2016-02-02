<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:07
 */

namespace App\Services\Works\Resources;

use App\Services\Entities\TagsEntity;


/**
 * Trait TagsEntities
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait TagsEntities
{

    /**
     * @return TagsEntity
     */
    protected function tagsEntity()
    {
        return new TagsEntity;
    }

}