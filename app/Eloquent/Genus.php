<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 上午11:22
 */

namespace App\Eloquent;


/**
 * Class Genus
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property int                                      family_id
 * @property string                                   title
 * @property string                                   chinese_title
 * @property int                                      species_id
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property Family                                   family
 * @property Species                                  typeSpecies
 * @property \Illuminate\Database\Eloquent\Collection species
 */
class Genus extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_genus';
    /**
     * @var array
     */
    protected $fillable = ['family_id', 'title', 'chinese_title', 'species_id',];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'family_id'     => 'integer',
        'title'         => 'string',
        'chinese_title' => 'string',
        'species_id'    => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Family', 'family_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeSpecies()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Species', 'species_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function species()
    {
        return $this->hasMany(__NAMESPACE__ . '\\Species', 'genus_id');
    }

}
