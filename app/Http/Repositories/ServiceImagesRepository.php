<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\ServiceImage;

class ServiceImagesRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new ServiceImage());
    }


    public function save($image, $id)
    {
        return $this->getModel()->create([
            'service_id' => $id,
            'file_path' => $image['file_path'],
            'file_type' => $image['file_type'],
            'file_default' => ($image['file_default'] == 1) ? 1 : 0,
        ]);
    }

}
