<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午10:03
 */

namespace App\Services\Repositories;


/**
 * Class KKSeedsRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\KKSeeds|\Illuminate\Database\Eloquent\Builder Model
 */
class KKSeedsRepository extends Repository
{

    /**
     * @param array $queries
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyByBaseQueries(array $queries)
    {
        $this->Model = $this->Model->orderBy('class_2')->orderBy('title');

        return parent::manyByBaseQueries($queries);
    }

    /**
     * @param string $date1
     * @param string $date2
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyBy2Date($date1, $date2)
    {
        return $this->Model
            ->whereIn('date', [$date1, $date2])
            ->get();
    }

}