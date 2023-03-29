<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repositories\ServiceRepository;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;
use App\Models\Page;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceRepository;
    public function __construct(ServiceRepository $serviceRepository,CategoryRepository $categoryRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->serviceRepository = $serviceRepository;
        $this->categoryRepository = $categoryRepository;
        $this->breadcrumbTitle = 'Services';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Services'];
        $categories = $this->categoryRepository->all(true);
        return view('admin.services.index',['categories' => $categories]);
    }
    public function all()
    {
     
        $services = $this->serviceRepository->allAdminServices();
        return response($services);
    }
    public function active($id)
    {

        try {

             $service = $this->serviceRepository->activate($id);
            if($service){
                return response(['msg' => 'Service Activated successfully']);
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

             $service = $this->serviceRepository->deActivate($id);
            if($service){
                return response(['msg' => 'Service Deactivated successfully']);
            }else{
                return response(['err' => 'something went wrong'],400);
            }

       } catch (\Exception $e) {
           return response(['err' => $e->getMessage()],400);
       }
    }
}
