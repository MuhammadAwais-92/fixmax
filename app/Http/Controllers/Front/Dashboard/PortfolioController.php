<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use App\Http\Dtos\AddProjectDto;
use App\Http\Requests\ProjectRequest;


class PortfolioController extends Controller
{
    protected $projectRepository;
    public function __construct(ProjectRepository $projectRepository)
    {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->projectRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function index()
    {
        $this->breadcrumbTitle = __('Portfolio');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Portfolio')];
        $this->projectRepository->setPaginate(6);
        $this->projectRepository->setRelations([
            'images:id,file_path,file_default,file_type,project_id',
        ]);
        $projects = $this->projectRepository->all();
        foreach ($projects as $project) {
            $project->getFormattedModel();
        }
        return view(
            'front.dashboard.projects.manage-project',
            [
                'projects' => $projects
            ]
        );
    }
    public function create()
    {
        $this->breadcrumbTitle = __('Portfolio');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Portfolio')];
        $project = $this->projectRepository->getModel();
        return view(
            'front.dashboard.projects.edit-project',
            [
                'project' => $project
            ]
        );
    }
    public function detail($id)
    {
        $this->breadcrumbTitle = __('Portfolio');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Portfolio')];
        $this->projectRepository->setRelations([
            'images:id,file_path,file_default,file_type,project_id',
        ]);
        $project = $this->projectRepository->get($id);
        return view(
            'front.dashboard.projects.project-detail',
            [
                'project' => $project
            ]
        );
    }
    public function edit($id)
    {


        $this->breadcrumbTitle = __('Portfolio');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Portfolio')];
        $this->projectRepository->setRelations([
            'images:id,file_path,file_default,file_type,project_id',
        ]);
        $project = $this->projectRepository->get($id);
        return view('front.dashboard.projects.edit-project', [
            'project' => $project
        ]);
    }
    public function save(ProjectRequest $request, $id)
    {
        try {
            $addProjectDto = AddProjectDto::fromRequest($request);
            $this->projectRepository->save($addProjectDto);
            if ($request->id != null) {
                session()->flash('status', __('Project updated successful.'));
            } else {
                session()->flash('status', __('Project created successful.'));
            }
            return redirect(route('front.dashboard.projects.index'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function delete($id)
    {
        $equipment =  $this->projectRepository->destroy($id);
        if ($equipment) {
            return redirect()->back()->with('status', __('Project deleted successfully.'));
        }
        return redirect()->back()->with('err', __('Something went wrong'));

    }
}
