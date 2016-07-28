<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午1:28
 */

namespace App\Eloquent;


/**
 * Class Hybrids
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property string                                   title
 * @property string                                   alias
 * @property string                                   description
 * @property string                                   content
 * @property int                                      covers_id
 * @property int                                      left_plants_id
 * @property int                                      right_plants_id
 * @property int                                      user_id
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property Plants                                   leftplants
 * @property Plants                                   rightplants
 * @property HybridsImages                            images
 * @property \Illuminate\Database\Eloquent\Collection tagslink
 * @property \Illuminate\Database\Eloquent\Collection tags
 * @property HybridsCovers                            cover
 * @property \Illuminate\Database\Eloquent\Collection covers
 */
class Hybrids extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_hybrids';
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'covers_id',
        'left_plants_id',
        'right_plants_id',
        'user_id',
    ];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'              => 'integer',
        'title'           => 'string',
        'alias'           => 'string',
        'description'     => 'string',
        'content'         => 'string',
        'covers_id'       => 'integer',
        'left_plants_id'  => 'integer',
        'right_plants_id' => 'integer',
        'user_id'         => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leftplants()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Plants', 'left_plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rightplants()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Plants', 'right_plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(__NAMESPACE__ . '\\HybridsImages', 'hybrids_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagslink()
    {
        return $this->hasMany(__NAMESPACE__ . '\\TagsHybrids', 'hybrids_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Tags',
            'link_tags_hybrids', 'hybrids_id', 'tags_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cover()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\HybridsCovers', 'covers_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function covers()
    {
        return $this->hasMany(__NAMESPACE__ . '\\HybridsCovers', 'hybrids_id');
    }

}