<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/6
 * Time: 下午4:42
 */

namespace App\Services\Works\Resources;

use App\Eloquent\Family;
use App\Eloquent\Genus;
use App\Eloquent\Plants;
use App\Eloquent\PlantsImages;
use App\Eloquent\PlantsSame;
use App\Eloquent\Species;
use App\Eloquent\Subspecies;
use App\Eloquent\Varietas;
use App\Services\Repositories\FamilyRepository;
use App\Services\Repositories\GenusRepository;
use App\Services\Repositories\PlantsImagesRepository;
use App\Services\Repositories\PlantsRepository;
use App\Services\Repositories\PlantsSameRepository;
use App\Services\Repositories\SpeciesRepository;
use App\Services\Repositories\SubspeciesRepository;
use App\Services\Repositories\VarietasRepository;


/**
 * Trait PlantsRepositories
 *
 * @package App\Services\Works\Resources
 * @author  sueysok
 */
trait PlantsRepositories
{

    /**
     * @var FamilyRepository
     */
    private $Family;
    /**
     * @var GenusRepository
     */
    private $Genus;
    /**
     * @var SpeciesRepository
     */
    private $Species;
    /**
     * @var SubspeciesRepository
     */
    private $Subspecies;
    /**
     * @var VarietasRepository
     */
    private $Varietas;
    /**
     * @var PlantsRepository
     */
    private $Plants;
    /**
     * @var PlantsImagesRepository
     */
    private $Images;
    /**
     * @var PlantsSameRepository
     */
    private $Same;

    /**
     * @return FamilyRepository
     */
    protected function familyRepository()
    {
        return $this->Family ?: $this->Family = new FamilyRepository(new Family);
    }

    /**
     * @return GenusRepository
     */
    protected function genusRepository()
    {
        return $this->Genus ?: $this->Genus = new GenusRepository(new Genus);
    }

    /**
     * @return SpeciesRepository
     */
    protected function speciesRepository()
    {
        return $this->Species ?: $this->Species = new SpeciesRepository(new Species);
    }

    /**
     * @return SubspeciesRepository
     */
    protected function subspeciesRepository()
    {
        return $this->Subspecies ?: $this->Subspecies = new SubspeciesRepository(new Subspecies);
    }

    /**
     * @return VarietasRepository
     */
    protected function varietasRepository()
    {
        return $this->Varietas ?: $this->Varietas = new VarietasRepository(new Varietas);
    }

    /**
     * @return PlantsRepository
     */
    protected function plantsRepository()
    {
        return $this->Plants ?: $this->Plants = new PlantsRepository(new Plants);
    }

    /**
     * @return PlantsImagesRepository
     */
    protected function plantsImagesRepository()
    {
        return $this->Images ?: $this->Images = new PlantsImagesRepository(new PlantsImages);
    }

    /**
     * @return PlantsSameRepository
     */
    protected function plantsSameRepository()
    {
        return $this->Same ?: $this->Same = new PlantsSameRepository(new PlantsSame);
    }

}