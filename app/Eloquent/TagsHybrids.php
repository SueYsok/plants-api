<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/2
 * Time: 下午1:59
 */

namespace App\Eloquent;


/**
 * Class TagsHybrids
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            tags_id
 * @property int            hybrids_id
 * @property string         tags_title
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class TagsHybrids extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'link_tags_hybrids';
    /**
     * @var array
     */
    protected $fillable = ['tags_id', 'hybrids_id', 'tags_title',];
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
        'hybrids_id' => 'integer',
        'tags_title' => 'string',
    ];

}
