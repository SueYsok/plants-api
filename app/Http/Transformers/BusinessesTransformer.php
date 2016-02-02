<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午5:45
 */

namespace App\Http\Transformers;

use App\Services\Entities\BusinessesEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class BusinessesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class BusinessesTransformer extends TransformerAbstract
{

    /**
     * @param BusinessesEntity $BusinessesEntity
     *
     * @return array
     */
    public function transform(BusinessesEntity $BusinessesEntity)
    {
        return [
            'kind'     => 'businesses',
            'id'       => $BusinessesEntity->getId(),
            'title'    => $BusinessesEntity->getTitle(),
            'web_site' => $BusinessesEntity->getWebSite(),
            'country'  => $BusinessesEntity->getCountry(),
        ];
    }

}