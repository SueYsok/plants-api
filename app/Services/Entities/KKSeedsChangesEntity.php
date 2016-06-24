<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/24
 * Time: 上午10:06
 */

namespace App\Services\Entities;

use App\Exceptions\EntityException;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Support\Collection;


/**
 * Class KKSeedsChangesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class KKSeedsChangesEntity extends Entity
{

    /**
     * @var \Carbon\Carbon
     */
    protected $newDate;
    /**
     * @var \Carbon\Carbon
     */
    protected $oldDate;
    /**
     * @var Collection
     */
    protected $news;
    /**
     * @var Collection
     */
    protected $soldOud;
    /**
     * @var Collection
     */
    protected $changes;

    /**
     * @param ModelCollection $Collection
     *
     * @return KKSeedsChangesEntity
     */
    public function create($Collection)
    {
        $dates = $Collection->pluck('date')->unique()->toArray();

        if (count($dates) != 2) {
            throw new EntityException(__CLASS__, get_class($Collection->first()), 'date not usable');
        }

        /** @var \Carbon\Carbon $New */
        /** @var \Carbon\Carbon $Old */
        $this->newDate = head($dates);
        $this->oldDate = last($dates);
        if ($this->newDate->lt($this->oldDate)) {
            $temp = $this->newDate;
            $this->newDate = $this->oldDate;
            $this->oldDate = $temp;
        }

        $NewCollection = $Collection->whereLoose('date', $this->newDate);
        $OldCollection = $Collection->whereLoose('date', $this->oldDate);

        $this->changes = new Collection;

        $newArray = $NewCollection->toArray();
        $oldArray = $OldCollection->toArray();
        foreach ($oldArray as $oldKey => $old) {
            foreach ($newArray as $newKey => $new) {
                if ($new['number'] == $old['number']) {
                    if ($new['spec_pkt'] != $old['spec_pkt']
                        || $new['spec_100'] != $old['spec_100']
                        || $new['spec_1000'] != $old['spec_1000']
                        || $new['spec_10000'] != $old['spec_10000']
                    ) {
                        $this->changes->push($new);
                    }
                    unset($newArray[$newKey]);
                    unset($oldArray[$oldKey]);
                }
            }
        }

        $this->news = new Collection($newArray);
        $this->soldOud = new Collection($oldArray);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @return Collection
     */
    public function getSoldOud()
    {
        return $this->soldOud;
    }

    /**
     * @return Collection
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getNewDate()
    {
        return $this->newDate;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getOldDate()
    {
        return $this->oldDate;
    }

}