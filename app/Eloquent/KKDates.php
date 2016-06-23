<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午10:08
 */

namespace App\Eloquent;


/**
 * Class KKDates
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property \Carbon\Carbon date
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class KKDates extends Eloquent
{

    /**
     * @var string
     */
    protected $connection = 'mysql_v1_seeds';
    /**
     * @var string
     */
    protected $table = 'log_kk_dates';
    /**
     * @var array
     */
    protected $dates = ['date', 'created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

}