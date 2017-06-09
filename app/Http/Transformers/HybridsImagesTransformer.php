<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午5:52
 */

namespace App\Http\Transformers;

use App\Services\Entities\HybridsEntity;
use App\Services\Entities\HybridsImagesEntity;
use Illuminate\Support\Facades\Config;
use League\Fractal\TransformerAbstract;


/**
 * Class HybridsImagesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class HybridsImagesTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'hybrid',
    ];

    /**
     * @param HybridsImagesEntity $HybridsImagesEntity
     *
     * @return array
     */
    public function transform(HybridsImagesEntity $HybridsImagesEntity)
    {
        return [
            'kind' => 'hybrids_images',
            'id'   => $HybridsImagesEntity->getId(),
            'url'  => 'https://' . Config::get('path.images_domain') . $HybridsImagesEntity->getImage(),
        ];
    }

    /**
     * @param HybridsImagesEntity $HybridsImagesEntity
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includePlant(HybridsImagesEntity $HybridsImagesEntity)
    {
        if ($HybridsImagesEntity->getHybrids() instanceof HybridsEntity) {
            return $this->item($HybridsImagesEntity->getHybrids(), new HybridsTransformer);
        } else {
            return null;
        }
    }

}