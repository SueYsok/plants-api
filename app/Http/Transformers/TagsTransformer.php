<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午10:55
 */

namespace App\Http\Transformers;

use App\Services\Entities\HybridsEntity;
use App\Services\Entities\PlantsEntity;
use App\Services\Entities\TagsEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class TagsTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class TagsTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'plants',
        'hybrids',
    ];

    /**
     * @param TagsEntity $TagsEntity
     *
     * @return array
     */
    public function transform(TagsEntity $TagsEntity)
    {
        return [
            'kind'  => 'tags',
            'id'    => $TagsEntity->getId(),
            'title' => $TagsEntity->getTitle(),
            'count' => $TagsEntity->getCount(),
        ];
    }

    /**
     * @param TagsEntity $TagsEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includePlants(TagsEntity $TagsEntity)
    {
        if ($TagsEntity->getPlants()->first() instanceof PlantsEntity) {
            return $this->collection($TagsEntity->getPlants(), new PlantsTransformer);
        } else {
            return null;
        }
    }

    /**
     * @param TagsEntity $TagsEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeHybrids(TagsEntity $TagsEntity)
    {
        if ($TagsEntity->getHybrids()->first() instanceof HybridsEntity) {
            return $this->collection($TagsEntity->getHybrids(), new HybridsTransformer);
        } else {
            return null;
        }
    }

}