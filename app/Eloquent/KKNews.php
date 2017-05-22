<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 2017/5/18
 * Time: 下午12:05
 */

namespace App\Eloquent;


/**
 * Class KKNews
 *
 * @package App\Eloquent
 * @author  sueysok
 * @property int                                      id
 * @property \Carbon\Carbon                           new_date
 * @property \Carbon\Carbon                           old_date
 * @property array                                    news_seeds_ids
 * @property array                                    sold_out_seeds_ids
 * @property array                                    changes_seeds_ids
 * @property \Carbon\Carbon                           created_at
 * @property \Carbon\Carbon                           updated_at
 * @property \Illuminate\Database\Eloquent\Collection newsSeeds
 * @property \Illuminate\Database\Eloquent\Collection soldOutSeeds
 * @property \Illuminate\Database\Eloquent\Collection changeSeeds
 */
class KKNews extends Eloquent
{

    /**
     * @var string
     */
    protected $connection = 'mysql_v1_seeds';
    /**
     * @var string
     */
    protected $table = 'index_kk_seeds_news';
    /**
     * @var array
     */
    protected $fillable = ['new_date', 'old_date', 'news_seeds_ids', 'sold_out_seeds_ids', 'changes_seeds_ids'];
    /**
     * @var array
     */
    protected $dates = ['new_date', 'old_date', 'created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $casts = [
        'id'                 => 'integer',
        'news_seeds_ids'     => 'array',
        'sold_out_seeds_ids' => 'array',
        'changes_seeds_ids'  => 'array',
    ];

    /**
     * @param null $value
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNewsSeedsAttribute($value = null)
    {
        return (new KKSeeds)->whereIn('id', $this->news_seeds_ids)->get();
    }

    /**
     * @param null $value
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSoldOutSeedsAttribute($value = null)
    {
        return (new KKSeeds)->whereIn('id', $this->sold_out_seeds_ids)->get();
    }

    /**
     * @param null $value
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChangeSeedsAttribute($value = null)
    {
        return (new KKSeeds)->whereIn('id', $this->changes_seeds_ids)->get();
    }

}