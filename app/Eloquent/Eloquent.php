<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 15/11/3
 * Time: 上午11:11
 */

namespace App\Eloquent;


use App\Contracts\Model;
use Illuminate\Database\Eloquent\Model as BaseEloquent;

/**
 * Class Eloquent
 *
 * @package App\Eloquent
 * @author  sueysok
 */
abstract class Eloquent extends BaseEloquent implements Model
{

    /**
     * @var string
     */
    protected $connection = 'mysql_v1_species';

    /**
     * @return string
     */
    public function getModelName()
    {
        return get_called_class();
    }

}