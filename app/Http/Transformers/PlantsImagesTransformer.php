<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/2
 * Time: 上午10:57
 */

namespace App\Http\Transformers;

use App\Services\Entities\PlantsEntity;
use App\Services\Entities\PlantsImagesEntity;
use Illuminate\Support\Facades\Config;
use League\Fractal\TransformerAbstract;


/**
 * Class PlantsImagesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class PlantsImagesTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'plant',
    ];

    /**
     * @param PlantsImagesEntity $PlantsImagesEntity
     *
     * @return array
     */
    public function transform(PlantsImagesEntity $PlantsImagesEntity)
    {
        return [
            'kind' => 'plants_images',
            'id'   => $PlantsImagesEntity->getId(),
            'url'  => 'https://' . Config::get('path.images_domain') . $PlantsImagesEntity->getImage(),
        ];
    }

    /**
     * @param PlantsImagesEntity $PlantsImagesEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlant(PlantsImagesEntity $PlantsImagesEntity)
    {
        if ($PlantsImagesEntity->getPlants() instanceof PlantsEntity) {
            return $this->item($PlantsImagesEntity->getPlants(), new PlantsTransformer);
        } else {
            return null;
        }
    }

}