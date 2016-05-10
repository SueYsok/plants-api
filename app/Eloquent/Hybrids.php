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
 * @property int            id
 * @property string         title
 * @property string         alias
 * @property string         description
 * @property string         cover
 * @property int            left_plants_id
 * @property int            right_plants_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Plants         leftplants
 * @property Plants         rightplants
 *
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
        'cover',
        'left_plants_id',
        'right_plants_id',
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
        'cover'           => 'string',
        'left_plants_id'  => 'integer',
        'right_plants_id' => 'integer',
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

}