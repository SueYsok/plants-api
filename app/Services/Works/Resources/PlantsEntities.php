<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午4:58
 */

namespace App\Services\Works\Resources;

use App\Services\Entities\FamilyEntity;
use App\Services\Entities\GenusEntity;
use App\Services\Entities\PlantsEntity;
use App\Services\Entities\PlantsImagesEntity;
use App\Services\Entities\SpeciesEntity;
use App\Services\Entities\SubspeciesEntity;
use App\Services\Entities\TypeSpeciesEntity;
use App\Services\Entities\VarietasEntity;


/**
 * Trait PlantsEntities
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait PlantsEntities
{

    /**
     * @return FamilyEntity
     */
    protected function familyEntity()
    {
        return new FamilyEntity;
    }

    /**
     * @return GenusEntity
     */
    protected function genusEntity()
    {
        return new GenusEntity;
    }

    /**
     * @return SpeciesEntity
     */
    protected function speciesEntity()
    {
        return new SpeciesEntity;
    }

    /**
     * @return SubspeciesEntity
     */
    protected function subspeciesEntity()
    {
        return new SubspeciesEntity;
    }

    /**
     * @return VarietasEntity
     */
    protected function varietasEntity()
    {
        return new VarietasEntity;
    }

    /**
     * @return TypeSpeciesEntity
     */
    protected function typeSpeciesEntity()
    {
        return new TypeSpeciesEntity;
    }

    /**
     * @return PlantsEntity
     */
    protected function plantsEntity()
    {
        return new PlantsEntity;
    }

    /**
     * @return PlantsImagesEntity
     */
    protected function imagesEntity()
    {
        return new PlantsImagesEntity;
    }

}