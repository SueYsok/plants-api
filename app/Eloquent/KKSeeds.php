<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午9:45
 */

namespace App\Eloquent;


/**
 * Class KKSeeds
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property string         class_1
 * @property string         class_2
 * @property string         title
 * @property string         number
 * @property string         spec_pkt
 * @property string         spec_100
 * @property string         spec_1000
 * @property string         spec_10000
 * @property \Carbon\Carbon date
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class KKSeeds extends Eloquent
{

    /**
     * @var string
     */
    protected $connection = 'mysql_v1_seeds';
    /**
     * @var string
     */
    protected $table = 'log_kk_seeds';
    /**
     * @var array
     */
    protected $dates = ['date', 'created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'class_1'    => 'string',
        'class_2'    => 'string',
        'title'      => 'string',
        'number'     => 'int',
        'spec_pkt'   => 'bool',
        'spec_100'   => 'bool',
        'spec_1000'  => 'bool',
        'spec_10000' => 'bool',
    ];

}