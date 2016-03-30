<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/3/16
 * Time: 下午3:56
 */

namespace App\Exceptions;


/**
 * Class WorkException
 *
 * @package App\Exceptions
 * @author  sueysok
 */
class WorkException extends JJMMException
{

    /**
     * @param int $code
     */
    public function __construct($code)
    {
        parent::__construct('', $code);
    }

}