<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 上午11:21
 */

namespace App\Eloquent;


/**
 * Class Family
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property string                                   title
 * @property string                                   chinese_title
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property \Illuminate\Database\Eloquent\Collection genus
 */
class Family extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'data_family';
    /**
     * @var array
     */
    protected $fillable = ['title', 'chinese_title',];
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
        'chinese_title' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function genus()
    {
        return $this->hasMany(__NAMESPACE__ . '\\Genus', 'family_id');
    }

}
