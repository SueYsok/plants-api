<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 上午11:28
 */

namespace App\Eloquent;


/**
 * Class Species
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property int                                      genus_id
 * @property string                                   title
 * @property string                                   chinese_title
 * @property int                                      sub_process
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property Genus                                    genus
 * @property \Illuminate\Database\Eloquent\Collection subspecies
 * @property \Illuminate\Database\Eloquent\Collection varietas
 */
class Species extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_species';
    /**
     * @var array
     */
    protected $fillable = ['genus_id', 'title', 'chinese_title', 'sub_process'];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'genus_id'      => 'integer',
        'title'         => 'string',
        'chinese_title' => 'string',
        'sub_process'   => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genus()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Genus', 'genus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subspecies()
    {
        return $this->hasMany(__NAMESPACE__ . '\\Subspecies', 'species_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function varietas()
    {
        return $this->hasMany(__NAMESPACE__ . '\\Varietas', 'species_id');
    }

}
