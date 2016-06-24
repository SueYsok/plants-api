<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/6/24
 * Time: 上午11:45
 */

namespace App\Http\Transformers;

use App\Services\Entities\KKSeedsChangesEntity;
use League\Fractal\TransformerAbstract;


/**
 * Class KKChangesTransformer
 *
 * @package App\Http\Transformers
 * @author  sueysok
 */
class KKChangesTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'news',
        'sold_out',
        'changes',
    ];

    /**
     * @param KKSeedsChangesEntity $Entity
     *
     * @return array
     */
    public function transform(KKSeedsChangesEntity $Entity)
    {
        return [
            'kind'     => 'kk_changes',
            'new_date' => $Entity->getNewDate()->toDateString(),
            'old_date' => $Entity->getOldDate()->toDateString(),
        ];
    }

    /**
     * @param KKSeedsChangesEntity $Entity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeNews(KKSeedsChangesEntity $Entity)
    {
        return $this->collection($Entity->getNews(), new KKSeedsTransformer);
    }

    /**
     * @param KKSeedsChangesEntity $Entity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeSoldOut(KKSeedsChangesEntity $Entity)
    {
        return $this->collection($Entity->getSoldOud(), new KKSeedsTransformer);
    }

    /**
     * @param KKSeedsChangesEntity $Entity
     *
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeChanges(KKSeedsChangesEntity $Entity)
    {
        return $this->collection($Entity->getChanges(), new KKSeedsTransformer);
    }

}

