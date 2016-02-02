<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午9:58
 */

namespace App\Http\Transformers;

use App\Services\Entities\BusinessesEntity;
use App\Services\Entities\BusinessesPlantsEntity;
use App\Services\Entities\PlantsEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class BusinessesPlantsTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class BusinessesPlantsTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'business',
        'plant',
    ];

    /**
     * @param BusinessesPlantsEntity $BusinessesPlantsEntity
     *
     * @return array
     */
    public function transform(BusinessesPlantsEntity $BusinessesPlantsEntity)
    {
        return [
            'kind'        => 'businesses_plants',
            'id'          => $BusinessesPlantsEntity->getId(),
            'number'      => $BusinessesPlantsEntity->getNumber(),
            'description' => $BusinessesPlantsEntity->getDescription(),
            'price'       => json_decode($BusinessesPlantsEntity->getPrice(), true),
        ];
    }

    /**
     * @param BusinessesPlantsEntity $BusinessesPlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeBusiness(BusinessesPlantsEntity $BusinessesPlantsEntity)
    {
        if ($BusinessesPlantsEntity->getBusinesses() instanceof BusinessesEntity) {
            return $this->item($BusinessesPlantsEntity->getBusinesses(), new BusinessesTransformer);
        }

        return null;
    }

    /**
     * @param BusinessesPlantsEntity $BusinessesPlantsEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlant(BusinessesPlantsEntity $BusinessesPlantsEntity)
    {
        if ($BusinessesPlantsEntity->getPlants() instanceof PlantsEntity) {
            return $this->item($BusinessesPlantsEntity->getPlants(), new PlantsTransformer);
        }

        return null;
    }

}