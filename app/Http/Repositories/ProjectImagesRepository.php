<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\ProjectImage;
use Exception;
use ErrorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectImagesRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new ProjectImage());
    }


    public function save($image, $id)
    {
        return $this->getModel()->create([
            'project_id' => $id,
            'file_path' => $image['file_path'],
            'file_type' => $image['file_type'],
            'file_default' => ($image['file_default'] == 1) ? 1 : 0,
        ]);
    }

}
