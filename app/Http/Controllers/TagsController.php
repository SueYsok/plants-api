<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/2/1
 * Time: 下午1:02
 */

namespace App\Http\Controllers;

use App\Http\Transformers\TagsTransformer;
use App\Services\Works\Tags;
use Dingo\Api\Http\Request;
use Illuminate\Routing\Router;


/**
 * Class TagsController
 *
 * @package App\Http\Controllers
 * @author  sueysok
 */
class TagsController extends Controller
{

    /**
     * @var Tags
     */
    protected $Tags;

    /**
     * @param Request $Request
     * @param Router  $Route
     * @param Tags    $Tags
     */
    public function __construct(Request $Request, Router $Route, Tags $Tags)
    {
        parent::__construct($Request, $Route);

        $this->Tags = $Tags;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneTag()
    {
        $tagsId = $this->Route->input('tags_id');

        $TagsEntity = $this->Tags->one($tagsId);

        return $this->response()->item($TagsEntity, new TagsTransformer);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function allTags()
    {
        $TagsCollection = $this->Tags->many();

        return $this->response()->collection($TagsCollection, new TagsTransformer);
    }

}