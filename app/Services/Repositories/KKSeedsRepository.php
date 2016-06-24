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

}