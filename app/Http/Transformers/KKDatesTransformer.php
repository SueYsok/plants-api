<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午10:27
 */

namespace App\Http\Transformers;

use App\Eloquent\KKDates;
use League\Fractal\TransformerAbstract;


/**
 * Class KKDatesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class KKDatesTransformer extends TransformerAbstract
{

    /**
     * @param KKDates $KKDates
     *
     * @return array
     */
    public function transform(KKDates $KKDates)
    {
        return [
            'kind' => 'kk_dates',
            'id'   => $KKDates->id,
            'date' => $KKDates->date->toDateString(),
        ];
    }

}