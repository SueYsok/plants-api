<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/1/30
 * Time: 下午11:10
 */

namespace App\Eloquent;


/**
 * Class PlantsSame
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property int                                      major_plants_id
 * @property int                                      plants_id
 * @property Plants                                   plant
 * @property \Illuminate\Database\Eloquent\Collection same
 */
class PlantsSame extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'index_plants_same';
    /**
     * @var array
     */
    protected $fillable = ['major_plants_id', 'plants_id'];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'              => 'integer',
        'major_plants_id' => 'integer',
        'plants_id'       => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plant()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Plants', 'plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function same()
    {
        return $this->hasMany(__CLASS__, 'major_plants_id', 'major_plants_id');
    }

}
