<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午2:47
 */

namespace App\Eloquent;


/**
 * Class BusinessesPlants
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            businesses_id
 * @property int            plants_id
 * @property string         number
 * @property string         description
 * @property string         price
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Businesses     business
 * @property Plants         plant
 */
class BusinessesPlants extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_businesses_plants';
    /**
     * @var array
     */
    protected $fillable = ['businesses_id', 'plants_id', 'number', 'description', 'price',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'businesses_id' => 'integer',
        'plants_id'     => 'integer',
        'number'        => 'string',
        'description'   => 'string',
        'price'         => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Businesses', 'businesses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plant()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Plants', 'plants_id');
    }

}
