<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 14/11/28
 * Time: 下午2:15
 */

namespace App\Services\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Contracts\Model;


/**
 * Class BaseRepository
 *
 * @package App\Services\Repositories
 */
abstract class Repository
{

    /**
     * @var Model|\Illuminate\Database\Eloquent\Builder
     */
    protected $Model;

    /**
     * @param Model $Model
     */
    public function __construct(Model $Model)
    {
        $this->Model = $Model;
    }

    /**
     *
     */
    public function modelNotFound()
    {
        throw (new ModelNotFoundException)->setModel($this->Model->getModelName());
    }

    /**
     * @param callable $callback
     *
     * @return Model
     */
    public function one(Callable $callback = null)
    {
        /** @var Model|\Illuminate\Database\Eloquent\Builder $Model */
        $Model = is_callable($callback) ? call_user_func($callback, $this->Model) : $this->Model;

        return $Model->first();
    }

    /**
     * @param callable $callback
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function many(Callable $callback = null)
    {
        /** @var Model|\Illuminate\Database\Eloquent\Builder $Model */
        $Model = is_callable($callback) ? call_user_func($callback, $this->Model) : $this->Model;

        return $Model->get();
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return int
     */
    protected function page($page, $limit)
    {
        if ($page <= 0) {
            $page = 1;
        }

        return --$page * $limit;
    }

    /**
     * @param null|bool $active
     *
     * @return null|string
     */
    protected function makeActiveFunction($active)
    {
        if (false === $active) {
            $activeFunction = 'inactive';
        } elseif (true === $active) {
            $activeFunction = 'active';
        } else {
            $activeFunction = null;
        }

        return $activeFunction;
    }

}