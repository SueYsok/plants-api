<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午10:11
 */

namespace App\Services\Works;

use App\Services\Works\Resources\KKRepositories;


/**
 * Class KK
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class KK extends Work
{

    use KKRepositories;

    /**
     * @param array ...$input
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manySeeds(...$input)
    {
        $query = [];
        if (isset($input[0])) {
            $query['date'] = $input[0];
        }
        if (isset($input[1])) {
            $query['class_1'] = $input[1];
        }
        if (isset($input[2])) {
            $query['class_2'] = $input[2];
        }
        if (isset($input[3])) {
            $query['spec_pkt'] = $input[3] ? 1 : 0;
        }
        if (isset($input[4])) {
            $query['spec_100'] = $input[4] ? 1 : 0;
        }
        if (isset($input[5])) {
            $query['spec_1000'] = $input[5] ? 1 : 0;
        }
        if (isset($input[6])) {
            $query['spec_10000'] = $input[6] ? 1 : 0;
        }

        return $this->seedsRepository()->manyByBaseQueries($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function manyDates()
    {
        return $this->datesRepository()->many();
    }

}