<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/5/20
 * Time: 下午3:39
 */

namespace App\Services\Repositories;

use App\Eloquent\PlantsSame;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class PlantsSameRepository
 *
 * @package App\Services\Repositories
 * @author  sueysok
 * @property \App\Eloquent\PlantsSame|\Illuminate\Database\Eloquent\Builder Model
 */
class PlantsSameRepository extends Repository
{

    /**
     * @param int $plantsId
     * @param int $bindingId
     *
     * @return Collection
     */
    public function add($plantsId, $bindingId)
    {
        /** @var PlantsSame $SameCollection */
        $SameModel = $this->Model->where('plants_id', $bindingId)->first();
        $sameIds[] = $plantsId;

        if ($SameModel instanceof PlantsSame) {
            $majorId = $SameModel->major_plants_id;
        } else {
            $majorId = $plantsId;
            array_push($sameIds, $bindingId);
        }

        $Collection = new Collection;
        foreach ($sameIds as $sameId) {
            $PlantsSame = new PlantsSame;
            $PlantsSame->major_plants_id = $majorId;
            $PlantsSame->plants_id = $sameId;
            $PlantsSame->save();

            $Collection->push($PlantsSame);
        }

        return $Collection;
    }

    /**
     * @param int $plantsId
     */
    public function destroy($plantsId)
    {
        $SameModel = $this->Model
            ->with('same')
            ->where('plants_id', $plantsId)
            ->first();

        if ($SameModel instanceof PlantsSame) {
            if ($SameModel->same->count() <= 2) {
                $this->Model
                    ->where('major_plants_id', $SameModel->major_plants_id)
                    ->delete();
            } else {
                if ($plantsId == $SameModel->major_plants_id) {
                    $majorPlantsId = $plantsId;

                    /** @var PlantsSame $OtherSameModel */
                    foreach ($SameModel->same as $OtherSameModel) {
                        if ($OtherSameModel->plants_id != $plantsId) {
                            $majorPlantsId = $OtherSameModel->plants_id;
                            break;
                        }
                    }

                    foreach ($SameModel->same as $OtherSameModel) {
                        if ($OtherSameModel->plants_id != $plantsId) {
                            $OtherSameModel->major_plants_id = $majorPlantsId;
                            $OtherSameModel->save();
                        }
                    }
                }

                $this->Model
                    ->where('plants_id', $plantsId)
                    ->delete();
            }
        }
    }

}