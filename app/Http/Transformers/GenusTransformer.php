<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午9:50
 */

namespace App\Http\Transformers;

use App\Services\Entities\FamilyEntity;
use App\Services\Entities\GenusEntity;
use App\Services\Entities\TypeSpeciesEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class GenusTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class GenusTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'family',
        'typeSpecies',
        'species',
    ];

    /**
     * @param GenusEntity $GenusEntity
     *
     * @return array
     */
    public function transform(GenusEntity $GenusEntity)
    {
        return [
            'kind'          => 'genus',
            'id'            => $GenusEntity->getId(),
            'title'         => $GenusEntity->getTitle(),
            'chinese_title' => $GenusEntity->getChineseTitle(),
        ];
    }


    /**
     * @param GenusEntity $GenusEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeFamily(GenusEntity $GenusEntity)
    {
        if ($GenusEntity->getFamily() instanceof FamilyEntity) {
            return $this->item($GenusEntity->getFamily(), new FamilyTransformer);
        }

        return null;
    }

    /**
     * @param GenusEntity $GenusEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeTypeSpecies(GenusEntity $GenusEntity)
    {
        if ($GenusEntity->getTypeSpecies() instanceof TypeSpeciesEntity) {
            return $this->item($GenusEntity->getTypeSpecies(), new SpeciesTransformer);
        }

        return null;
    }

    /**
     * @param GenusEntity $GenusEntity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeSpecies(GenusEntity $GenusEntity)
    {
        if ($GenusEntity->getSpecies()->first() instanceof TypeSpeciesEntity) {
            return $this->collection($GenusEntity->getSpecies(), new SpeciesTransformer);
        } else {
            return null;
        }
    }

}