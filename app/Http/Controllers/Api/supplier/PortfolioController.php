<?php

namespace App\Http\Controllers\Api\supplier;

use App\Http\Controllers\Controller;
use App\Http\Dtos\AddProjectDto;
use App\Http\Repositories\ProjectRepository;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    protected object  $projectRepository, $categoryRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->projectRepository->setFromWeb(false);

    }

 
    public function delete($id)
    {
        

        try {
            $project =  $this->projectRepository->destroy($id);
            return responseBuilder()->success(__('project deleted successfully.'));
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }

    }

    public function all(Request $request)
    {
        $this->projectRepository->setPaginate(6);
        $this->projectRepository->setRelations([
            'images:id,file_path,file_default,file_type,project_id',
        ]);
        $portfolios = $this->projectRepository->all();
        foreach ($portfolios as $portfolio) {
            $portfolio->getFormattedModel();
        }

        if (!empty($portfolios)) {
            return responseBuilder()->success(__('portfolios'), $portfolios);
        }
        return responseBuilder()->error(__('portfolios Not Found'));
    }

    public function save(ProjectRequest $request)
    {
        try {
            $addProjectDto = AddProjectDto::fromRequest($request);

            $project = $this->projectRepository->save($addProjectDto);

            if ($request->id) {
                return responseBuilder()->success(__('project Updated Successfully'), ['project' => $project->getFormattedModel()]);
            } else {
                return responseBuilder()->success(__('project Added Successfully'), ['project' => $project->getFormattedModel()]);
            }
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function edit($id)
    {
   
        $this->projectRepository->setRelations([
            'images:id,file_path,file_default,file_type,project_id'
        ]);
        $project = $this->projectRepository->get($id);
      
        if (!empty($project)) {
            return responseBuilder()->success(__('project'), ['project' => $project->getFormattedModel()]);
        }
        return responseBuilder()->error(__('project Not Found'));
    }

}
