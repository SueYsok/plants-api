<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午9:52
 */

namespace App\Http\Transformers;

use App\Services\Entities\FamilyEntity;
use App\Services\Entities\GenusEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class FamilyTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class FamilyTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'genus',
    ];

    /**
     * @param FamilyEntity $FamilyEntity
     *
     * @return array
     */
    public function transform(FamilyEntity $FamilyEntity)
    {
        return [
            'kind'          => 'family',
            'id'            => $FamilyEntity->getId(),
            'title'         => $FamilyEntity->getTitle(),
            'chinese_title' => $FamilyEntity->getChineseTitle(),
        ];
    }

    /**
     * @param FamilyEntity $FamilyEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeGenus(FamilyEntity $FamilyEntity)
    {
        if ($FamilyEntity->getGenus()->first() instanceof GenusEntity) {
            return $this->collection($FamilyEntity->getGenus(), new GenusTransformer);
        } else {
            return null;
        }
    }

}

