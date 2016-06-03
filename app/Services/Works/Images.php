<?php
/**
 * Created by PhpStorm.
 * User: sueysok
 * Date: 16/3/16
 * Time: 下午3:26
 */

namespace App\Services\Works;

use App\Exceptions\WorkException;
use App\Services\Contracts\Storage;
use App\Services\Works\Resources\HybridsEntities;
use App\Services\Works\Resources\HybridsRepositories;
use App\Services\Works\Resources\PlantsEntities;
use App\Services\Works\Resources\PlantsRepositories;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;


/**
 * Class Images
 *
 * @package App\Services\Works
 * @author  sueysok
 */
class Images extends Work implements Storage
{

    use PlantsRepositories, PlantsEntities, HybridsRepositories, HybridsEntities;

    /**
     * @param mixed $input
     *
     * @return \App\Services\Entities\PlantsImagesEntity|\App\Services\Entities\HybridsImagesEntity
     */
    function add(...$input)
    {
        $objectId = $input[0];
        $userId = $input[1];
        $ImageFile = $input[2];
        $key = $input[3];

        try {
            $this->plantsRepository()->oneById($objectId);
        } catch (ModelNotFoundException $e) {
            throw new WorkException(self::PLANTS_MODEL_NOT_FOUND);
        }

        $imagesHome = Config::get('path.images_path') . Config::get('path.customer_images_path') . $userId . '/';
        $fileName = date('Ymd_His') . '.png';
        if (!File::exists($imagesHome)) {
            File::makeDirectory($imagesHome, 0755, true);
        }

        /** @var \Intervention\Image\Image $ImageFile */
        $ImageFile->save($imagesHome . $fileName);

        $image = '/' . Config::get('path.customer_images_path') . $userId . '/' . $fileName;

        $ImagesModel = $this->{$key . 'ImagesRepository'}()->add($objectId, $userId, $image);

        return $this->{$key . 'ImagesEntity'}()->create($ImagesModel);
    }

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function edit(...$input)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param int   $id
     * @param mixed $input
     */
    public function delete($id, ...$input)
    {
        $key = $input[0];

        $ImagesModel = $this->{$key . 'ImagesRepository'}()->oneSimpleById($id);
        $fileName = Config::get('path.images_path') . $ImagesModel->image;
        if (!File::delete($fileName)) {
            throw new WorkException(self::NOT_DELETE_FILE);
        }

        $this->{$key . 'ImagesRepository'}()->destroy($id);
    }

}