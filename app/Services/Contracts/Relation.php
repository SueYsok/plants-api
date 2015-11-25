<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/5/12
 * Time: 下午5:40
 */

namespace App\Services\Contracts;


/**
 * Interface Relation
 */
interface Relation
{

    /**
     * @param int   $fromId
     * @param int   $toId
     * @param array $input
     *
     * @return mixed
     */
    public function add($fromId, $toId, array $input);

    /**
     * @param int   $sideId
     * @param int   $relationId
     * @param array $input
     *
     * @return mixed
     */
    public function edit($sideId, $relationId, array $input);

    /**
     * @param int $sideId
     * @param int $relationId
     *
     * @return mixed
     */
    public function delete($sideId, $relationId);

}