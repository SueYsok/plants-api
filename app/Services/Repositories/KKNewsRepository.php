<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 2017/5/18
 * Time: 下午12:04
 */

namespace App\Services\Repositories;

use App\Eloquent\KKNews;


/**
 * Class KKNewsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property KKNews|\Illuminate\Database\Eloquent\Builder Model
 */
class KKNewsRepository extends Repository
{

    /**
     * @param string $newDate
     * @param string $oldDate
     * @param array  $newsSeedsIds
     * @param array  $soldOutSeedsIds
     * @param array  $changesSeedsIds
     *
     * @return KKNews
     */
    public function add($newDate, $oldDate, $newsSeedsIds, $soldOutSeedsIds, $changesSeedsIds)
    {
        $this->Model->new_date = $newDate;
        $this->Model->old_date = $oldDate;
        $this->Model->news_seeds_ids = $newsSeedsIds;
        $this->Model->sold_out_seeds_ids = $soldOutSeedsIds;
        $this->Model->changes_seeds_ids = $changesSeedsIds;

        $this->Model->save();

        return $this->Model;
    }

    /**
     * @param string $date
     *
     * @return KKNews
     */
    public function oneByNewDate($date)
    {
        /** @var KKNews $Model */
        $Model = parent::one(function ($Model) use ($date) {
            /** @var \Illuminate\Database\Query\Builder $Model */
            return $Model->where('new_date', $date);
        });

        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

}