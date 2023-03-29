<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\City;
use Exception;
use Illuminate\Support\Facades\DB;


class CityRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new City());
    }

    public function all($onlyParent = false)
    {
        $query = $this->getQuery();
        if ($onlyParent){
            $query->where('parent_id', 0);
        }
        $cities = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        return $cities;
    }
    public function allCities($onlyParent = false)
    {
        $query = $this->getQuery();
        if ($onlyParent) {
            $query->where('parent_id', 0)->has('areas');
        }
        $cities = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        return $cities;
    }
    public function destroy($id)
    {
        $city = $this->get($id);
        $city->areas()->delete();
        $city::destroy($id);
        return $city;
    }

    public function save($params, $id)
    {
        DB::beginTransaction();
        try {
           $city = $this->getModel()->updateOrCreate(['id' => $id], $params);
            DB::commit();
            return $city;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function get($id = 0)
    {
        $city = new City();
        if ($id > 0) {
            $city = $this->getModel()->select($this->getSelect())->with($this->getRelations())->findOrFail($id);
        }
        foreach (cache('LANGUAGES') as $lang) {

            if (is_null($city->name)) {
                $city->name = [];
                $city->name += [$lang['short_code'] => ''];
            } else {
                if (!array_key_exists($lang['short_code'], $city->name)) {

                    $city->name += [$lang['short_code'] => ''];
                }
            }
        }

        return $city;
    }
    public function areas($id)
    {
        $query = $this->getQuery();
        $data = $query->where('parent_id', $id)->where('deleted_at', null)->get();
        $startItem = [];
        $startItem['id'] = '';
        $startItem['name']['en'] = 'Select Delivery Area';
        $startItem['name']['ar'] = __('Select Delivery Area');
        $data->prepend($startItem);
        return $data;
    }
    function getAreas($id)
    {
        $query = $this->getQuery();
        $data = $query->where('parent_id', $id)->where('deleted_at', null)->get();
        return $data;
    }
}
