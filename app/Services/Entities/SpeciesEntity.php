<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/5
 * Time: 下午4:21
 */

namespace App\Services\Entities;

use App\Eloquent\Species;
use App\Exceptions\EntityException;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class SpeciesEntity
 *
 * @package App\Services\Entities
 * @author  sueysok
 */
class SpeciesEntity extends TypeSpeciesEntity
{

    /**
     * @var Collection
     */
    protected $items;

    /**
     * @param ModelCollection|Model $Item
     *
     * @return SpeciesEntity|Collection
     */
    public function create($Item)
    {
        if ($Item instanceof Species) {
            foreach (['id', 'genus_id', 'title', 'chinese_title', 'created_at', 'updated_at',] as $value) {
                if (isset($Item->{$value})) {
                    $this->{camel_case($value)} = $Item->{$value};
                }
            }

            if (isset($Item->sub_process)) {
                $this->subProcess = $Item->sub_process ? true : false;
            } else {
                throw new EntityException(__CLASS__, get_class($Item), 'sub_process is not set');
            }

            if ($Item->relationLoaded('genus')) {
                $this->genus = (new GenusEntity)->create($Item->genus);
            }

            if ($Item->relationLoaded('plants')) {
                $this->plants = (new PlantsEntity)->create($Item->plants);
            }

            if ($this->subProcess) {
                //有亚种
                if ($Item->relationLoaded('subspecies')) {
                    $SubspeciesCollection = $Item->subspecies;

                    //有变种
                    if ($Item->relationLoaded('varietas')) {
                        foreach ($SubspeciesCollection->all() as $key => $SubspeciesModel) {
                            /** @var \App\Eloquent\Subspecies $SubspeciesModel */
                            $SubspeciesModel->setRelation('varietas', new ModelCollection);

                            //变种合并到亚种下
                            foreach ($Item->varietas->all() as $VarietasModel) {
                                /** @var \App\Eloquent\Varietas $VarietasModel */
                                if ($SubspeciesModel->id == $VarietasModel->subspecies_id) {
                                    $SubspeciesModel->varietas->push($VarietasModel);
                                }
                            }

                            $SubspeciesCollection[$key] = $SubspeciesModel;
                        }
                    }

                    $this->items = (new SubspeciesEntity)->create($SubspeciesCollection);
                } else {
                    throw new EntityException(__CLASS__, get_class($Item), 'subspecies is not model');
                }
            } else {
                //无亚种
                if ($Item->relationLoaded('varietas')) {
                    //种下有变种
                    $this->items = (new VarietasEntity)->create($Item->varietas);
                } else {
                    //种下无分类
                    $this->items = new Collection;
                }
            }

            return $this;
        } else {
            $this->setCollection($Item);

            return $this->Collection;
        }
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

}