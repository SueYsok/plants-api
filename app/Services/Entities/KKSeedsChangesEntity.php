<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/24
 * Time: 上午10:06
 */

namespace App\Services\Entities;

use App\Eloquent\KKNews;
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
     * @param KKNews $NewsModel
     *
     * @return KKSeedsChangesEntity
     */
    public function create($NewsModel)
    {
        $this->newDate = $NewsModel->new_date;
        $this->oldDate = $NewsModel->old_date;
        $this->changes = $NewsModel->changeSeeds ?: new Collection;
        $this->news = $NewsModel->newsSeeds ?: new Collection;
        $this->soldOud = $NewsModel->soldOutSeeds ?: new Collection;

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