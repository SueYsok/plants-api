<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午10:16
 */

namespace App\Http\Transformers;

use App\Services\Entities\PlantsEntity;
use App\Services\Entities\SubspeciesEntity;
use App\Services\Entities\TypeSpeciesEntity;
use App\Services\Entities\VarietasEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class SubspeciesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class SubspeciesTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'species',
        'varietas',
        'plants',
    ];

    /**
     * @param SubspeciesEntity $SubspeciesEntity
     *
     * @return array
     */
    public function transform(SubspeciesEntity $SubspeciesEntity)
    {
        return [
            'kind'          => 'subspecies',
            'id'            => $SubspeciesEntity->getId(),
            'title'         => $SubspeciesEntity->getTitle(),
            'chinese_title' => $SubspeciesEntity->getChineseTitle(),
        ];
    }

    /**
     * @param SubspeciesEntity $SubspeciesEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeSpecies(SubspeciesEntity $SubspeciesEntity)
    {
        if ($SubspeciesEntity->getSpecies() instanceof TypeSpeciesEntity) {
            return $this->item($SubspeciesEntity->getSpecies(), new SpeciesTransformer);
        }

        return null;
    }

    /**
     * @param SubspeciesEntity $SubspeciesEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeVarietas(SubspeciesEntity $SubspeciesEntity)
    {
        if ($SubspeciesEntity->getVarietas()->first() instanceof VarietasEntity) {
            return $this->collection($SubspeciesEntity->getVarietas(), new VarietasTransformer);
        }

        return null;
    }

    /**
     * @param SubspeciesEntity $SubspeciesEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlants(SubspeciesEntity $SubspeciesEntity)
    {
        if ($SubspeciesEntity->getPlants() instanceof PlantsEntity) {
            return $this->item($SubspeciesEntity->getPlants(), new PlantsTransformer);
        } else {
            return null;
        }
    }

}