<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/1/30
 * Time: 下午11:06
 */

namespace App\Eloquent;


/**
 * Class TagsPlants
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            tags_id
 * @property int            plants_id
 * @property string         tags_title
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class TagsPlants extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'link_tags_plants';
    /**
     * @var array
     */
    protected $fillable = ['tags_id', 'plants_id', 'tags_title',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'tags_id'    => 'integer',
        'plants_id'  => 'integer',
        'tags_title' => 'string',
    ];

}
