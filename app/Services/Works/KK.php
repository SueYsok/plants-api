<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/23
 * Time: 上午10:11
 */

namespace App\Services\Works;

use App\Exceptions\WorkException;
use App\Services\Works\Resources\KKEntities;
use App\Services\Works\Resources\KKRepositories;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * Class KK
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class KK extends Work
{

    use KKRepositories, KKEntities;

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

    /**
     * @return \App\Eloquent\KKDates
     */
    public function lastDates()
    {
        return $this->datesRepository()->last();
    }

    /**
     * @param string $date
     *
     * @return \App\Services\Entities\KKSeedsChangesEntity
     */
    public function changes($date)
    {
        if (!$date) {
            $DatesModel = $this->datesRepository()->last();
            $date = $DatesModel->date->toDateString();
        }

        $NewsModel = $this->newsRepository()->oneByNewDate($date);

        return $this->seedsChangesEntity()->create($NewsModel);
    }

    /**
     * @return \App\Services\Entities\KKSeedsChangesEntity
     */
    public function generateNews()
    {
        $date = $this->lastDates()->date->toDateString();

        try {
            $NewsModel = $this->newsRepository()->oneByNewDate($date);
        } catch (ModelNotFoundException $e) {
            $NewDatesModel = $this->datesRepository()->last();
            if ($NewDatesModel->date->ne(new Carbon($date))) {
                throw new WorkException(self::HAS_NO_DATE);
            }

            $OldDatesModel = $this->datesRepository()->lastBeforeDate($date);

            $SeedsCollection = $this->seedsRepository()->manyBy2Date($date, $OldDatesModel->date->toDateString());

            $dates = $SeedsCollection->pluck('date')->unique()->toArray();

            if (count($dates) != 2) {
                throw new WorkException(self::HAS_NO_DATE);
            }

            /** @var Carbon $NewDate */
            $NewDate = head($dates);
            /** @var Carbon $OldDate */
            $OldDate = last($dates);
            if ($NewDate->lt($OldDate)) {
                $temp = $NewDate;
                $NewDate = $OldDate;
                $OldDate = $temp;
            }

            $NewCollection = $SeedsCollection->whereLoose('date', $NewDate);
            $OldCollection = $SeedsCollection->whereLoose('date', $OldDate);

            $changes = [];
            $news = $NewCollection->toArray();
            $olds = $OldCollection->toArray();
            foreach ($olds as $oldKey => $old) {
                foreach ($news as $newKey => $new) {
                    if ($new['number'] == $old['number']) {
                        if ($new['spec_pkt'] != $old['spec_pkt']
                            || $new['spec_100'] != $old['spec_100']
                            || $new['spec_1000'] != $old['spec_1000']
                            || $new['spec_10000'] != $old['spec_10000']
                        ) {
                            array_push($changes, $new);
                        }
                        unset($news[$newKey]);
                        unset($olds[$oldKey]);
                    }
                }
            }

            $NewsModel = $this->newsRepository()->add(
                $NewDate->toDateString(),
                $OldDate->toDateString(),
                array_pluck($news, 'id'),
                array_pluck($olds, 'id'),
                array_pluck($changes, 'id')
            );
        }

        return $this->seedsChangesEntity()->create($NewsModel);
    }

}