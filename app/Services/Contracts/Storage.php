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
 */
interface Storage
{

    /**
     * @param int   $belongId
     * @param array $input
     *
     * @return mixed
     */
    public function add($belongId, array $input);

    /**
     * @param int   $belongId
     * @param int   $dataId
     * @param array $input
     *
     * @return mixed
     */
    public function edit($belongId, $dataId, array $input);

    /**
     * @param int $belongId
     * @param int $dataId
     *
     * @return mixed
     */
    public function delete($belongId, $dataId);

}