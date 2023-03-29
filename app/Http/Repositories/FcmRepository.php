<?php


namespace App\Http\Repositories;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Fcm;
use App\Models\User;
use Exception;

class FcmRepository extends Repository
{

    public function __construct()
    {
        $this->model = new Fcm;
    }
    public function all()
    {
        return $this->model->all();
    }
    public function save($request, $user,$id)
    {
        $data['fcm_token'] = $request->get('fcm_token');
        $data['user_id'] = $user->id;
        $fcm_token = $this->model->where('fcm_token', $data['fcm_token'])->first();
        if ($fcm_token !== null) {
                return false;
        }
        else{
            $this->model->updateOrCreate(['id' => $id], $data);
        }
    }
}