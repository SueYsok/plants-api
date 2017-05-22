<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午10:08
 */

namespace App\Services\Repositories;

use App\Eloquent\KKDates;


/**
 * Class KKDatesRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\KKDates|\Illuminate\Database\Eloquent\Builder Model
 */
class KKDatesRepository extends Repository
{

    /**
     * @param callable $callback
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function many(Callable $callback = null)
    {
        if (is_null($callback)) {
            $callback = function ($Model) {
                /** @var \Illuminate\Database\Query\Builder $Model */
                return $Model->orderBy('date', 'desc');
            };
        }

        return parent::many($callback);
    }

    /**
     * @return KKDates
     */
    public function last()
    {
        /** @var KKDates $Model */
        $Model = parent::one(function ($Model) {
            /** @var \Illuminate\Database\Query\Builder $Model */
            return $Model->orderBy('date', 'desc');
        });

        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

    /**
     * @param string $date
     *
     * @return KKDates
     */
    public function lastBeforeDate($date)
    {
        /** @var KKDates $Model */
        $Model = parent::one(function ($Model) use ($date) {
            /** @var \Illuminate\Database\Query\Builder $Model */
            return $Model->where('date', '<', $date)->orderBy('date', 'desc');
        });

        if (is_null($Model)) {
            $this->modelNotFound();
        }

        return $Model;
    }

}