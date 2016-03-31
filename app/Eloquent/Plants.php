<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午2:19
 */

namespace App\Eloquent;


/**
 * Class Plants
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property string                                   title
 * @property string                                   alias
 * @property string                                   description
 * @property string                                   cover
 * @property int                                      family_id
 * @property int                                      genus_id
 * @property int                                      species_id
 * @property int                                      subspecies_id
 * @property int                                      varietas_id
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property Family                                   family
 * @property Genus                                    genus
 * @property Species                                  species
 * @property Subspecies                               subspecies
 * @property Varietas                                 varietas
 * @property \Illuminate\Database\Eloquent\Collection images
 * @property \Illuminate\Database\Eloquent\Collection tags
 * @property PlantsSame                               same
 */
class Plants extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_plants';
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'cover',
        'family_id',
        'genus_id',
        'species_id',
        'subspecies_id',
        'varietas_id',
    ];
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'title'         => 'string',
        'alias'         => 'string',
        'description'   => 'string',
        'cover'         => 'string',
        'family_id'     => 'integer',
        'genus_id'      => 'integer',
        'species_id'    => 'integer',
        'subspecies_id' => 'integer',
        'varietas_id'   => 'integer',
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
    public function genus()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Genus', 'genus_id');
    }

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
    public function subspecies()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Subspecies', 'subspecies_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function varietas()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Varietas', 'varietas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(__NAMESPACE__ . '\\PlantsImages', 'plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Tags',
            'link_tags_plants', 'plants_id', 'tags_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function businesses()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Businesses',
            'data_businesses_plants', 'plants_id', 'businesses_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function same()
    {
        return $this->hasOne(__NAMESPACE__ . '\\PlantsSame', 'plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagslink()
    {
        return $this->hasMany(__NAMESPACE__ . '\\TagsPlants', 'plants_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businesseslink()
    {
        return $this->hasMany(__NAMESPACE__ . '\\BusinessesPlants', 'plants_id');
    }

}