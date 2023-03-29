<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repositories\EquipmentRepository;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    protected $equipmentRepository;
    public function __construct(EquipmentRepository $equipmentRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->equipmentRepository = $equipmentRepository;
        $this->breadcrumbTitle = 'Equipments';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Equipments'];
        return view('admin.equipments.index');
    }
    public function all()
    {
     
        $services = $this->equipmentRepository->allAdminEquipments();
        return response($services);
    }
    public function active($id)
    {

        try {

             $service = $this->equipmentRepository->activate($id);
            if($service){
                return response(['msg' => 'Equipment Activated successfully']);
            }else{
                return response(['err' => 'something went wrong'],400);
            }

       } catch (\Exception $e) {
           return response(['err' => $e->getMessage()],400);
       }
    }
    public function deActive($id)
    {

        try {

             $service = $this->equipmentRepository->deActivate($id);
            if($service){
                return response(['msg' => 'Equipment Deactivated successfully']);
            }else{
                return response(['err' => 'something went wrong'],400);
            }

       } catch (\Exception $e) {
           return response(['err' => $e->getMessage()],400);
       }
    }
}
