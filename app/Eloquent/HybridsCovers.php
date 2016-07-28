<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/7/6
 * Time: 上午11:33
 */

namespace App\Eloquent;


/**
 * Class HybridsCovers
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            hybrids_id
 * @property int            user_id
 * @property string         image
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Hybrids        hybrids
 */
class HybridsCovers extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_hybrids_covers';
    /**
     * @var array
     */
    protected $fillable = ['hybrids_id', 'user_id', 'image',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'hybrids_id' => 'integer',
        'image'      => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hybrids()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Hybrids', 'hybrids_id');
    }

}

