<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午9:56
 */

namespace App\Http\Transformers;

use App\Eloquent\KKSeeds;
use League\Fractal\TransformerAbstract;


/**
 * Class KKSeedsTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class KKSeedsTransformer extends TransformerAbstract
{

    /**
     * @param KKSeeds $KKSeeds
     *
     * @return array
     */
    public function transform(KKSeeds $KKSeeds)
    {
        return [
            'kind'       => 'kk_seeds',
            'id'         => $KKSeeds->id,
            'number'     => $KKSeeds->number,
            'title'      => $KKSeeds->title,
            'spec_pkt'   => $KKSeeds->spec_pkt,
            'spec_100'   => $KKSeeds->spec_100,
            'spec_1000'  => $KKSeeds->spec_1000,
            'spec_10000' => $KKSeeds->spec_1000,
            'date'       => $KKSeeds->date->toDateString(),
            'class_1'    => $KKSeeds->class_1,
            'class_2'    => $KKSeeds->class_2,
        ];
    }

}