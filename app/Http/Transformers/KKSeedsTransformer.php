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
     * @param \ArrayAccess $KKSeeds
     *
     * @return array
     */
    public function transform($KKSeeds)
    {
        if ($KKSeeds instanceof KKSeeds) {
            $KKSeeds->toArray();
        }

        return [
            'kind'             => 'kk_seeds',
            'id'               => $KKSeeds['id'],
            'number'           => $KKSeeds['number'],
            'title'            => $KKSeeds['title'],
            'spec_pkt'         => $KKSeeds['spec_pkt'],
            'spec_pkt_price'   => $KKSeeds['spec_pkt_price'],
            'spec_100'         => $KKSeeds['spec_100'],
            'spec_100_price'   => $KKSeeds['spec_100_price'],
            'spec_1000'        => $KKSeeds['spec_1000'],
            'spec_1000_price'  => $KKSeeds['spec_1000_price'],
            'spec_10000'       => $KKSeeds['spec_10000'],
            'spec_10000_price' => $KKSeeds['spec_10000_price'],
            'date'             => rtrim($KKSeeds['date'], ' 00:00:00'),
            'class_1'          => $KKSeeds['class_1'],
            'class_2'          => $KKSeeds['class_2'],
        ];
    }

}