<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\ServiceImagesRepository;
use App\Models\Addresses;
use App\Http\Libraries\DataTable;

class AddressRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(new Addresses());
    }
    public function all()
    {
        $query = $this->getQuery();
        $user=$this->getUser();
        $query = $query->where('user_id', $user->id);
        if ($this->getPaginate() > 0) {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $services;
    }
    public function allCurrentAddresses($id)
    {
        $query = $this->getQuery();
        $user=$this->getUser();
        $query = $query->where('user_id', $user->id)->where('area_id',$id);
        if ($this->getPaginate() > 0) {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $services;
    }
    public function get($id)
    {
        $query = $this->getModel()->query();
        $this->getUser();
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        $equipment = $query->select($this->getSelect())->with($this->getRelations())->first();
        return $equipment;
    }


    public function save($params)
    {
        DB::beginTransaction();
        try {
            $data = $params->except('id');
            $user = $this->getUser();
            // $ifDefault = $this->getModel()->where('user_id', $user->id)->count();
            // if ($ifDefault == 0) {
            //     $data['default_address'] = 1;
            // }
            $address = $this->getModel()->updateOrCreate(['id' => $params['id']], $data);
            $res = $this->getModel()->where('user_id', $user->id)->update(['default_address' => 0]);
            $res = $this->getModel()->where('id', $address->id)->update(['default_address' => 1]);
            DB::commit();
            return $address;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function delete($id)
    {
        try {

            $user = $this->getUser();
            $this->getQuery()->where('id', $id)->delete();

            $updateDefault = $this->getModel()->where('user_id', $user->id)->get();

            if (!empty($updateDefault[0])) {
                $updateDefault[0]->default_address = 1;
                $updateDefault[0]->save();
            }

            return true;
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function makeDefault($request)
    {
        DB::beginTransaction();
        try {
            $user = $this->getUser();
            $res = $this->getModel()->where('user_id', $user->id)->update(['default_address' => 0]);
            $res = $this->getModel()->where('id', $request->get('id'))->update(['default_address' => 1]);
            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
