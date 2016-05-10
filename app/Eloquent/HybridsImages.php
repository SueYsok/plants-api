<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/9
 * Time: 下午1:33
 */

namespace App\Eloquent;


/**
 * Class HybridsImages
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
class HybridsImages extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_hybrids_images';
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