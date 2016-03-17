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

    use PlantsRepositories, PlantsEntities;

    /**
     * @param mixed $input
     *
     * @return \App\Services\Entities\PlantsImagesEntity
     */
    function add(...$input)
    {
        $plantsId = $input[0];
        $userId = $input[1];
        $ImageFile = $input[2];

        try {
            $this->plantsRepository()->oneById($plantsId);
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

        $ImagesModel = $this->imagesRepository()->add($plantsId, $userId, $image);

        return $this->imagesEntity()->create($ImagesModel);
    }

    /**
     * @param int   $id
     * @param mixed $input
     *
     * @return mixed
     */
    public function edit($id, ...$input)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $ImagesModel = $this->imagesRepository()->oneSimpleById($id);
        $fileName = Config::get('path.images_path') . $ImagesModel->image;
        if (!File::delete($fileName)) {
            throw new WorkException(self::NOT_DELETE_FILE);
        }

        $this->imagesRepository()->destroy($id);
    }

}