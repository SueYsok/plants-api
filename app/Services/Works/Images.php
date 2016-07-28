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
use Intervention\Image\Image;


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

        $this->checkObject($objectId, $key);

        $image = $this->upload($ImageFile, $userId);

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
     * @param array $input
     *
     * @return bool
     */
    public function delete($id, ...$input)
    {
        $key = $input[0];

        $ImagesModel = $this->{$key . 'ImagesRepository'}()->oneSimpleById($id);

        $this->remove($ImagesModel->image);

        $this->{$key . 'ImagesRepository'}()->destroy($id);

        return true;
    }

    /**
     * @param int    $objectId
     * @param int    $userId
     * @param Image  $ImageFile
     * @param string $key
     */
    public function addCover($objectId, $userId, Image $ImageFile, $key)
    {
        $ObjectModel = $this->checkObject($objectId, $key);

        $image = $this->upload($ImageFile, $userId);

        $CoversModel = $this->{$key . 'CoversRepository'}()->add($objectId, $userId, $image);

        $ObjectModel->covers_id = $CoversModel->id;
        $ObjectModel->save();
    }

    /**
     * @param int    $id
     * @param string $key
     *
     * @return bool
     */
    public function deleteCover($id, $key)
    {
        $this->{$key . 'Repository'}()->resetCoversId($id);

        $ImagesModel = $this->{$key . 'CoversRepository'}()->oneSimpleById($id);

        $this->remove($ImagesModel->image);

        $this->{$key . 'CoversRepository'}()->destroy($id);

        return true;
    }

    /**
     * @param string $image
     */
    protected function remove($image)
    {
        $fileName = Config::get('path.images_path') . $image;
        if (!File::delete($fileName)) {
            throw new WorkException(self::NOT_DELETE_FILE);
        }
    }

    /**
     * @param Image $ImageFile
     * @param int   $userId
     *
     * @return string
     */
    protected function upload(Image $ImageFile, $userId)
    {
        $imagesHome = Config::get('path.images_path') . Config::get('path.customer_images_path') . $userId . '/';

        $fileName = date('Ymd_His') . '.png';
        if (!File::exists($imagesHome)) {
            File::makeDirectory($imagesHome, 0755, true);
        }

        $ImageFile->save($imagesHome . $fileName);

        return '/' . Config::get('path.customer_images_path') . $userId . '/' . $fileName;
    }

    /**
     * @param int    $objectId
     * @param string $key
     *
     * @return \App\Eloquent\Plants|\App\Eloquent\Hybrids
     */
    protected function checkObject($objectId, $key)
    {
        try {
            return $this->{$key . 'Repository'}()->oneById($objectId);
        } catch (ModelNotFoundException $e) {
            throw new WorkException(self::PLANTS_MODEL_NOT_FOUND);
        }
    }

}