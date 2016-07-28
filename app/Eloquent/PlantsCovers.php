<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/7/6
 * Time: 上午11:34
 */

namespace App\Eloquent;


/**
 * Class PlantsCovers
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            plants_id
 * @property int            user_id
 * @property string         image
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Plants         plant
 */
class PlantsCovers extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_plants_covers';
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plant()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Plants', 'plants_id');
    }

}