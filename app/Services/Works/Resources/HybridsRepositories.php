<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午1:57
 */

namespace App\Services\Works\Resources;

use App\Eloquent\Hybrids;
use App\Eloquent\HybridsImages;
use App\Services\Repositories\HybridsImagesRepository;
use App\Services\Repositories\HybridsRepository;


/**
 * Trait HybridsRepositories
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait HybridsRepositories
{

    /**
     * @var HybridsRepository
     */
    private $Hybrids;
    /**
     * @var HybridsImagesRepository
     */
    private $Images;

    /**
     * @return HybridsRepository
     */
    protected function hybridsRepository()
    {
        return $this->Hybrids ?: $this->Hybrids = new HybridsRepository(new Hybrids);
    }

    /**
     * @return HybridsImagesRepository
     */
    protected function hybridsImagesRepository()
    {
        return $this->Images ?: $this->Images = new HybridsImagesRepository(new HybridsImages);
    }

}