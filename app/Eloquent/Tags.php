<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/1/30
 * Time: 下午11:04
 */

namespace App\Eloquent;


/**
 * Class Tags
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property int                                      user_id
 * @property string                                   title
 * @property int                                      count
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property \Illuminate\Database\Eloquent\Collection plants
 */
class Tags extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_tags';
    /**
     * @var array
     */
    protected $fillable = ['title', 'count'];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'title' => 'string',
        'count' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plants()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Plants', 'link_tags_plants', 'tags_id', 'plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hybrids()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Hybrids', 'link_tags_hybrids', 'tags_id', 'hybrids_id');
    }

}
