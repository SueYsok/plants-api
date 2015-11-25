<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午1:42
 */

namespace App\Eloquent;


/**
 * Class Subspecies
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property int                                      species_id
 * @property string                                   title
 * @property string                                   chinese_title
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property Species                                  species
 * @property \Illuminate\Database\Eloquent\Collection varietas
 */
class Subspecies extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_subspecies';
    /**
     * @var array
     */
    protected $fillable = ['species_id', 'title', 'chinese_title',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'species_id'    => 'integer',
        'title'         => 'string',
        'chinese_title' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function species()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Species', 'species_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function varietas()
    {
        return $this->hasMany(__NAMESPACE__ . '\\Varietas', 'subspecies_id');
    }

}
