<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:07
 */

namespace App\Services\Works\Resources;

use App\Eloquent\Tags;
use App\Services\Repositories\TagsRepository;


/**
 * Trait TagsRepositories
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait TagsRepositories
{

    /**
     * @var TagsRepository
     */
    private $Tags;

    /**
     * @return TagsRepository
     */
    protected function tagsRepository()
    {
        return $this->Tags ?: $this->Tags = new TagsRepository(new Tags);
    }

}