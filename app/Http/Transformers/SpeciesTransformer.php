<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午9:39
 */

namespace App\Http\Transformers;

use App\Services\Entities\GenusEntity;
use App\Services\Entities\PlantsEntity;
use App\Services\Entities\SpeciesEntity;
use App\Services\Entities\SubspeciesEntity;
use App\Services\Entities\TypeSpeciesEntity;
use App\Services\Entities\VarietasEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class SpeciesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class SpeciesTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'subspecies',
        'varietas',
        'genus',
        'plants',
    ];

    /**
     * @param TypeSpeciesEntity $TypeSpeciesEntity
     *
     * @return array
     */
    public function transform(TypeSpeciesEntity $TypeSpeciesEntity)
    {
        return [
            'kind'          => 'species',
            'id'            => $TypeSpeciesEntity->getId(),
            'title'         => $TypeSpeciesEntity->getTitle(),
            'chinese_title' => $TypeSpeciesEntity->getChineseTitle(),
            'description'   => $TypeSpeciesEntity->getDescription(),
        ];
    }


    /**
     * @param TypeSpeciesEntity $TypeSpeciesEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeGenus(TypeSpeciesEntity $TypeSpeciesEntity)
    {
        if ($TypeSpeciesEntity->getGenus() instanceof GenusEntity) {
            return $this->item($TypeSpeciesEntity->getGenus(), new GenusTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param TypeSpeciesEntity $TypeSpeciesEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlants(TypeSpeciesEntity $TypeSpeciesEntity)
    {
        if ($TypeSpeciesEntity->getPlants() instanceof PlantsEntity) {
            return $this->item($TypeSpeciesEntity->getPlants(), new PlantsTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param TypeSpeciesEntity $SpeciesEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeVarietas(TypeSpeciesEntity $SpeciesEntity)
    {
        if ($SpeciesEntity instanceof SpeciesEntity) {
            if ($SpeciesEntity->getItems()->first() instanceof VarietasEntity) {
                return $this->collection($SpeciesEntity->getItems(), new VarietasTransformer);
            }
        }

        return null;
    }

    /**
     * @param TypeSpeciesEntity $SpeciesEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeSubspecies(TypeSpeciesEntity $SpeciesEntity)
    {
        if ($SpeciesEntity instanceof SpeciesEntity) {
            if ($SpeciesEntity->getItems()->first() instanceof SubspeciesEntity) {
                return $this->collection($SpeciesEntity->getItems(), new SubspeciesTransformer);
            }
        }

        return null;
    }

}