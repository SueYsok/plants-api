<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午2:34
 */

namespace App\Eloquent;


/**
 * Class PlantsImages
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            plants_id
 * @property int            user_id
 * @property string         image
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Plants         plants
 */
class PlantsImages extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_plants_images';
    /**
     * @var array
     */
    protected $fillable = ['plants_id', 'user_id', 'image',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'plants_id' => 'integer',
        'image'     => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plants()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Plants', 'plants_id');
    }

}