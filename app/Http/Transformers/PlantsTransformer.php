<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午11:07
 */

namespace App\Http\Transformers;

use App\Services\Entities\FamilyEntity;
use App\Services\Entities\GenusEntity;
use App\Services\Entities\PlantsEntity;
use App\Services\Entities\PlantsImagesEntity;
use App\Services\Entities\SubspeciesEntity;
use App\Services\Entities\TagsEntity;
use App\Services\Entities\TypeSpeciesEntity;
use App\Services\Entities\VarietasEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class PlantsTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class PlantsTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'family',
        'genus',
        'species',
        'subspecies',
        'varietas',
        'images',
        'tags',
        'same',
    ];

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return array
     */
    public function transform(PlantsEntity $PlantsEntity)
    {
        return [
            'kind'          => 'plants',
            'id'            => $PlantsEntity->getId(),
            'family_id'     => $PlantsEntity->getFamilyId(),
            'genus_id'      => $PlantsEntity->getGenusId(),
            'species_id'    => $PlantsEntity->getSpeciesId(),
            'subspecies_id' => $PlantsEntity->getSubspeciesId(),
            'varietas'      => $PlantsEntity->getVarietasId(),
            'title'         => $PlantsEntity->getTitle(),
            'description'   => $PlantsEntity->getDescription(),
        ];
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeFamily(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getFamily() instanceof FamilyEntity) {
            return $this->item($PlantsEntity->getFamily(), new FamilyTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeGenus(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getGenus() instanceof GenusEntity) {
            return $this->item($PlantsEntity->getGenus(), new GenusTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeSpecies(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getSpecies() instanceof TypeSpeciesEntity) {
            return $this->item($PlantsEntity->getSpecies(), new SpeciesTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeSubspecies(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getSubspecies() instanceof SubspeciesEntity) {
            return $this->item($PlantsEntity->getSubspecies(), new SubspeciesTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeVarietas(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getVarietas() instanceof VarietasEntity) {
            return $this->item($PlantsEntity->getVarietas(), new VarietasTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeImages(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getImages()->first() instanceof PlantsImagesEntity) {
            return $this->collection($PlantsEntity->getImages(), new PlantsImagesTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeTags(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getTags()->first() instanceof TagsEntity) {
            return $this->collection($PlantsEntity->getTags(), new TagsTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param PlantsEntity $PlantsEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeSame(PlantsEntity $PlantsEntity)
    {
        if ($PlantsEntity->getPlants()->first() instanceof PlantsEntity) {
            return $this->collection($PlantsEntity->getPlants(), new self);
        } else {
            return null;
        }
    }

}