<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 上午11:15
 */

namespace App\Eloquent;


/**
 * Class Businesses
 *
 * @package   App\Eloquent
 * @author    sueysok
 * @property int            id
 * @property string         title
 * @property string         web_site
 * @property string         country
 * @property string         description
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Businesses extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_businesses';
    /**
     * @var array
     */
    protected $fillable = ['title', 'web_site', 'country', 'description',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'title'       => 'string',
        'web_site'    => 'string',
        'country'     => 'string',
        'description' => 'string',
    ];

}
