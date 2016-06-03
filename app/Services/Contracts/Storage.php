<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/5/12
 * Time: 下午5:38
 */

namespace App\Services\Contracts;


/**
 * Interface Storage
 *
 * @package App\Services\Contracts
 * @author  sueysok
 */
interface Storage
{

    /**
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function add(...$input);

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function edit(...$input);

    /**
     * @param int   $dataId
     * @param mixed $input
     *
     * @return mixed
     */
    public function delete($dataId, ...$input);

}