<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午5:39
 */

namespace App\Http\Transformers;

use App\Services\Entities\HybridsEntity;
use App\Services\Entities\HybridsImagesEntity;
use App\Services\Entities\PlantsEntity;
use Illuminate\Support\Collection;
use League\Fractal\TransformerAbstract;


/**
 * Class HybridsTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class HybridsTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'plants',
        'images',
    ];

    /**
     * @param HybridsEntity $HybridsEntity
     *
     * @return array
     */
    public function transform(HybridsEntity $HybridsEntity)
    {
        $plantsIds = [];
        if (is_int($HybridsEntity->getLeftPlantsId())) {
            array_push($plantsIds, $HybridsEntity->getLeftPlantsId());
        }
        if (is_int($HybridsEntity->getRightPlantsId())) {
            array_push($plantsIds, $HybridsEntity->getRightPlantsId());
        }

        return [
            'kind'        => 'hybrids',
            'id'          => $HybridsEntity->getId(),
            'title'       => $HybridsEntity->getTitle(),
            'alias'       => $HybridsEntity->getAlias(),
            'description' => $HybridsEntity->getDescription(),
            'plants_ids'  => $plantsIds,
        ];
    }

    /**
     * @param HybridsEntity $HybridsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlants(HybridsEntity $HybridsEntity)
    {
        $plants = [];

        if ($HybridsEntity->getLeftPlants() instanceof PlantsEntity) {
            array_push($plants, $HybridsEntity->getLeftPlants());
        }

        if ($HybridsEntity->getRightPlants() instanceof PlantsEntity) {
            array_push($plants, $HybridsEntity->getRightPlants());
        }

        return $this->collection(new Collection($plants), new PlantsTransformer);
    }

    /**
     * @param HybridsEntity $HybridsEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeImages(HybridsEntity $HybridsEntity)
    {
        if ($HybridsEntity->getImages()->first() instanceof HybridsImagesEntity) {
            return $this->collection($HybridsEntity->getImages(), new HybridsImagesTransformer);
        } else {
            return null;
        }
    }

}