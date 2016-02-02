<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午3:02
 */

namespace App\Services\Entities;

use App\Exceptions\EntityException;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;


/**
 * Class Entity
 *
 * @package App\Services\Entities
 */
abstract class Entity implements Arrayable, Jsonable, JsonSerializable
{

    /**
     * @var \Carbon\Carbon|null
     */
    protected $createdAt;

    /**
     * @var \Carbon\Carbon|null
     */
    protected $updatedAt;

    /**
     * @var bool
     */
    protected $timestamps = true;

    /**
     * @var Collection
     */
    protected $Collection = null;

    /**
     * @param ModelCollection $ModelCollection
     */
    protected function setCollection(ModelCollection $ModelCollection)
    {
        $this->collection();

        if (!$ModelCollection->isEmpty()) {
            foreach ($ModelCollection->all() as $Model) {
                $this->makeCollection(function ($Collection) use ($Model) {
                    /** @var Collection $Collection */
                    $Collection->push((new static)->create($Model));
                });
            }
        } else {
            $this->Collection->make(null);
        }
    }

    /**
     * @param callable $callback
     */
    protected function makeCollection(Callable $callback)
    {
        call_user_func($callback, $this->Collection);
    }

    /**
     * @param array $entities
     *
     * @return Collection
     */
    protected function collection(array $entities = [])
    {
        if (!$this->Collection) {
            $this->Collection = new Collection($entities);
        }
    }

    /**
     * @param array                 $attributes
     * @param ModelCollection|Model $Model
     */
    protected function checkModel(array $attributes, $Model)
    {
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                if (!$Model->{$key} instanceof Model) {
                    throw new EntityException(get_called_class(), get_class($Model),
                        $key . ' is not model');
                }
                $this->checkModel($value, $Model->{$key});
            } else {
                if (!isset($Model->{$value})) {
                    throw new EntityException(get_called_class(), get_class($Model),
                        $value . ' is not set');
                }
            }
        }
    }

    /**
     * @param ModelCollection|Model $Item
     *
     * @return Entity|Collection
     */
    public abstract function create($Item);

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = (new \ReflectionClass($this))->getDefaultProperties();
        unset($attributes['Collection']);
        unset($attributes['timestamps']);

        $array = [];
        foreach ($attributes as $key => $value) {
            $getFunction = 'get' . ucfirst($key);
            $value = $this->{$getFunction}();
            if ($value instanceof self || $value instanceof Collection) {
                $array[snake_case($key)] = $value->toArray();
            } else {
                $array[snake_case($key)] = $value;
            }
        }

        return $array;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param bool $origin
     *
     * @return null|string|\Carbon\Carbon
     */
    public function getCreatedAt($origin = false)
    {
        return $this->formatCarbon('createdAt', $origin);
    }

    /**
     * @param bool $origin
     *
     * @return null|string|\Carbon\Carbon
     */
    public function getUpdatedAt($origin = false)
    {
        return $this->formatCarbon('updatedAt', $origin);
    }

    private function formatCarbon($key, $origin)
    {
        return $this->timestamps
            ? ($origin
                ? $this->{$key}
                : ($this->{$key}
                    ? $this->{$key}->toRfc3339String()
                    : null))
            : null;
    }

}

