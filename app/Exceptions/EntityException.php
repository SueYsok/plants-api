<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 下午3:05
 */

namespace App\Exceptions;


/**
 * Class EntityException
 *
 * @package App\Exceptions
 * @author  sueysok
 */
class EntityException extends JJMMException
{

    /**
     * @param string $entity
     * @param string $item
     * @param string $info
     */
    public function __construct($entity, $item, $info)
    {
        $message = 'Cannot create entity [' . $entity . '] usage origin [' . $item . ']. Info: [' . $info . ']';
        parent::__construct($message);
    }

}