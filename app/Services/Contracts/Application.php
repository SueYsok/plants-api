<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/5/12
 * Time: 下午5:40
 */

namespace App\Services\Contracts;


/**
 * Interface Application
 */
interface Application
{

    /**
     * @param int   $fromId
     * @param int   $toId
     * @param array $input
     *
     * @return mixed
     */
    public function apply($fromId, $toId, array $input);

    /**
     * @param int   $toId
     * @param int   $requestId
     * @param array $input
     *
     * @return mixed
     */
    public function accede($toId, $requestId, array $input);

    /**
     * @param int $toId
     * @param int $requestId
     *
     * @return mixed
     */
    public function refuse($toId, $requestId);

    /**
     * @param int $fromId
     * @param int $requestId
     *
     * @return mixed
     */
    public function retract($fromId, $requestId);

}