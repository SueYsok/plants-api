<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午10:14
 */

namespace App\Http\Transformers;

use App\Services\Entities\PlantsEntity;
use App\Services\Entities\TypeSpeciesEntity;
use App\Services\Entities\VarietasEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class VarietasTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class VarietasTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'species',
        'subspecies',
        'plants',
    ];


    /**
     * @param VarietasEntity $VarietasEntity
     *
     * @return array
     */
    public function transform(VarietasEntity $VarietasEntity)
    {
        return [
            'kind'          => 'varietas',
            'id'            => $VarietasEntity->getId(),
            'title'         => $VarietasEntity->getTitle(),
            'chinese_title' => $VarietasEntity->getChineseTitle(),
        ];
    }

    /**
     * @param VarietasEntity $VarietasEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeSpecies(VarietasEntity $VarietasEntity)
    {
        if ($VarietasEntity->getSpecies() instanceof TypeSpeciesEntity) {
            return $this->item($VarietasEntity->getSpecies(), new SpeciesTransformer);
        }

        return null;
    }

    /**
     * @param VarietasEntity $VarietasEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeSubspecies(VarietasEntity $VarietasEntity)
    {
        if ($VarietasEntity->getSubspecies() instanceof SubspeciesTransformer) {
            return $this->item($VarietasEntity->getSubspecies(), new SubspeciesTransformer);
        }

        return null;
    }

    /**
     * @param VarietasEntity $VarietasEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlants(VarietasEntity $VarietasEntity)
    {
        if ($VarietasEntity->getPlants() instanceof PlantsEntity) {
            return $this->item($VarietasEntity->getPlants(), new PlantsTransformer);
        } else {
            return null;
        }
    }

}