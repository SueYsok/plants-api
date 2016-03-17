<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/7/29
 * Time: 下午5:31
 */

namespace App\Services\Contracts;


/**
 * Interface Selection
 *
 * @package App\Services\Contracts
 * @author  sueysok
 */
interface Selection
{

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return mixed
     */
    public function one($id, ...$input);

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function many(...$input);

    /**
     * @param mixed $index
     *
     * @return int
     */
    public function id($index);

}