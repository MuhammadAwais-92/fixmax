<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repositories\ProjectRepository;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    protected $projectRepository;
    public function __construct(ProjectRepository $projectRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->projectRepository = $projectRepository;
        $this->breadcrumbTitle = 'Portfolio';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Portfolio'];
        return view('admin.portfolio.index');
    }
    public function all()
    {
     
        $services = $this->projectRepository->allAdminProjects();
        return response($services);
    }
    public function active($id)
    {

        try {

             $project = $this->projectRepository->activate($id);
            if($project){
                return response(['msg' => 'Activated successfully']);
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

             $project = $this->projectRepository->deActivate($id);
            if($project){
                return response(['msg' => 'Deactivated successfully']);
            }else{
                return response(['err' => 'something went wrong'],400);
            }

       } catch (\Exception $e) {
           return response(['err' => $e->getMessage()],400);
       }
    }
}
