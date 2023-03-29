<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\UserArea;
use Exception;
use Illuminate\Support\Facades\DB;


class CoveredAreasRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new UserArea());
    }



    public function save($data)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            // $newAreas = array_filter($data, function ($var) {
            //     return ($var['id'] <= 0);
            // });
            // $updateAreas = array_filter($data, function ($var) {
            //     return ($var['id'] > 0);
            // });
            // if (count($updateAreas) > 0) {
            $user->coveredAreas()->detach(array_column($data, 'city_id'));

            $user->coveredAreas()->sync($data);
            // }
            // if (count($newAreas) > 0) {
            //     $user->coveredAreas()->attach($newAreas);
            // }
            DB::commit();
            $result = 'updated';
            // if (count($updateAreas) > 0) {
            $result = 'updated';
            // } else {
            $result = 'added';
            // }
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
