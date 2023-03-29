<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\ServiceImagesRepository;
use App\Models\Equipment;
use App\Http\Libraries\DataTable;

class EquipmentRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(new Equipment());
    }
    public function all()
    {
        $query = $this->getQuery();
        $query = $query->where('user_id', auth()->user()->id);
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
    public function allAdminEquipments()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'equipment_model', 'dt' => 'equipment_model'],
            ['db' => 'price', 'dt' => 'price'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'service_id', 'dt' => 'service_id'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'make', 'dt' => 'make'],
            ['db' => 'name', 'dt' => 'name'],

        ];
        DataTable::init(new Equipment(), $columns);
        // $supplier = request('datatable.query.supplier_id', '');
        $title = request('datatable.query.title', '');
        if (!empty($title)) {
                //                DataTable::where('supplier_name', 'LIKE', '%' . addslashes($title) . '%');
                DataTable::where('name', 'LIKE', '%' . $title . '%');
            
        }
        // $min = request('datatable.query.min', '');
        // $max = request('datatable.query.max', '');
        // if (!empty($title)) {
        //     DataTable::whereJsonContains('name->en', $title);
        // }
        // if (!empty($min)) {
        //     DataTable::where('price', '>', $min);
        // }
        // if (!empty($max)) {
        //     DataTable::where('price', '<', $max);
        // }
        // if (!empty($category)) {


        //     // DataTable::where('admin_status', '=', 'pending');
        DataTable::with('supplier');
        DataTable::with('service');
        DataTable::whereHas('service');
        //     DataTable::whereHas('categories', function ($query) use ($category) {
        //         return $query->where('category_id', $category);
        //     });
        //     // DataTable::whereJsonContains('name->en',$category);
        // }

        $equipments = DataTable::get();
        $start = 1;
        if ($equipments['meta']['start'] > 0 && $equipments['meta']['page'] > 1) {
            $start = $equipments['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($equipments['data']) > 0) {
            foreach ($equipments['data'] as $key => $data) {
                $equipments['data'][$key]['id'] = $count++;
                $equipments['data'][$key]['en_name'] = $data['name']['en'];
                $equipments['data'][$key]['ar_name'] = $data['name']['ar'];
                $equipments['data'][$key]['make'] = $data['make'];
                $equipments['data'][$key]['equipment_model'] = $data['equipment_model'];
                $equipments['data'][$key]['price'] = $data['price'];
                $equipments['data'][$key]['supplier_name']  =$equipments['data'][$key]['supplier']['supplier_name']['en'];
                $equipments['data'][$key]['service']  =$equipments['data'][$key]['service']['name']['en'];
                $equipments['data'][$key]['Activate'] = $data['is_active']=='1' ? 'Active' : 'In-Active';
                if($data['is_active'] == '1')
                {
                    $equipments['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill deactivate-record-button href="javascript:{};" data-url="' . route('admin.dashboard.equipment.off', $data['id'])  . '" title="Delete"><i class="fa fa-check"></i></a>';
                }
              else{
                $equipments['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill activate-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.equipment.on', $data['id']) . '" title="Accept"> <i class="fa fa-times"></i></a>';
              }
               
            }
        }
        return $equipments;
    }
    public function activate($id)
    {
        try {
            $equipment = $this->get($id);
            $equipment->is_active='1';
            $equipment->save();
            return true;
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function deActivate($id)
    {
        try {
            $equipment = $this->get($id);
            $equipment->is_active='0';
            $equipment->save();
            return true;
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function save($params)
    {
        DB::beginTransaction();
        try {
            $data=$params->toArray();
            $equipment = $this->getModel()->updateOrCreate(['id' => $params->id], $data);
            DB::commit();
            return $equipment;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function destroy($id)
    {
        $query = $this->getModel()->query()->find($id)->delete();
        if($query)
        {
            return true;
        }
        return  false;
    }
}
