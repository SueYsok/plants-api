<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午1:45
 */

namespace App\Eloquent;


/**
 * Class Varietas
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int            id
 * @property int            species_id
 * @property int            subspecies_id
 * @property string         title
 * @property string         chinese_title
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property Species        species
 * @property Subspecies     subspecies
 */
class Varietas extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_varietas';
    /**
     * @var array
     */
    protected $fillable = ['species_id', 'subspecies_id', 'title', 'chinese_title',];
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
        'subspecies_id' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subspecies()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Subspecies', 'subspecies_id');
    }

}
