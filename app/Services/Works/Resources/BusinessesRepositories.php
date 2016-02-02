<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午5:11
 */

namespace App\Services\Works\Resources;

use App\Eloquent\Businesses;
use App\Eloquent\BusinessesPlants;
use App\Services\Repositories\BusinessesPlantsRepository;
use App\Services\Repositories\BusinessesRepository;


/**
 * Trait BusinessesRepositories
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait BusinessesRepositories
{

    /**
     * @var BusinessesRepository
     */
    private $Businesses;
    /**
     * @var BusinessesPlantsRepository
     */
    private $Plants;

    /**
     * @return BusinessesRepository
     */
    protected function businessesRepository()
    {
        return $this->Businesses ?: $this->Businesses = new BusinessesRepository(new Businesses);
    }

    /**
     * @return BusinessesPlantsRepository
     */
    protected function plantsRepository()
    {
        return $this->Plants ?: $this->Plants = new BusinessesPlantsRepository(new BusinessesPlants);
    }

}