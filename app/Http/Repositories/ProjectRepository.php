<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\ServiceImagesRepository;
use App\Models\Project;
use App\Http\Libraries\DataTable;


class ProjectRepository extends Repository
{
    protected $projectImagesRepository;
    public function __construct()
    {
        $this->setModel(new Project());
        $this->projectImagesRepository = new ProjectImagesRepository;
    }
    public function all()
    {
        $query = $this->getQuery();
        $query = $query->where('user_id', auth()->user()->id);
        if ($this->getPaginate() > 0) {
            $projects = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $projects = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $projects;
    }
    // get particular supplier projects
    public function supplierProjects($id)
    {
        $query = $this->getQuery();
        $query = $query->where('user_id', $id);
        if ($this->getPaginate() > 0) {
            $projects = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate(),['*'],'projects');
        } else {
            $projects = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $projects;
    }
    public function get($id)
    {
        $query = $this->getModel()->query();
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        $equipment = $query->select($this->getSelect())->with($this->getRelations())->first();
        return $equipment;
    }

    public function allAdminProjects()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            // ['db' => 'created_at', 'dt' => 'created_at'],
            // ['db' => 'updated_at', 'dt' => 'updated_at'],
            //            ['db' => 'deleted_at', 'dt' => 'deleted_at'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'name', 'dt' => 'name'],

        ];
        DataTable::init(new Project(), $columns);
        // $supplier = request('datatable.query.supplier_id', '');
        $title = request('datatable.query.title', '');
        if (!empty($title)) {
                //                DataTable::where('supplier_name', 'LIKE', '%' . addslashes($title) . '%');
                DataTable::where('name->en', 'LIKE', '%' . $title . '%');
            
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
        //     DataTable::whereHas('categories', function ($query) use ($category) {
        //         return $query->where('category_id', $category);
        //     });
        //     // DataTable::whereJsonContains('name->en',$category);
        // }

        $projects = DataTable::get();
        $start = 1;
        if ($projects['meta']['start'] > 0 && $projects['meta']['page'] > 1) {
            $start = $projects['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($projects['data']) > 0) {
            foreach ($projects['data'] as $key => $data) {
                $projects['data'][$key]['id'] = $count++;
                $projects['data'][$key]['en_name'] = $data['name']['en'];
                $projects['data'][$key]['ar_name'] = $data['name']['ar'];
                $projects['data'][$key]['supplier_name']  =$projects['data'][$key]['supplier']['supplier_name']['en'];
                $projects['data'][$key]['Activate'] = $data['is_active']=='1' ? 'Active' : 'De-Active';
                $projects['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill activate-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.project.on', $data['id']) . '" title="Accept"> <i class="fa fa-check"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill deactivate-record-button href="javascript:{};" data-url="' . route('admin.dashboard.project.off', $data['id'])  . '" title="Delete"><i class="fa fa-times"></i></a>';
            }
        }
        return $projects;
    }
    public function activate($id)
    {
        try {
            $project = $this->get($id);
            $project->is_active='1';
            $project->save();
            return true;
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function deActivate($id)
    {
        try {
            $project = $this->get($id);
            $project->is_active='0';
            $project->save();
            return true;
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function save($params)
    {
        DB::beginTransaction();
        try {
            $data = $params->except('project_images')->toArray();
            $project = $this->getModel()->updateOrCreate(['id' => $params->id], $data);
            if ($params->id && $params->id != 0) {
                $projectImages = $project->images()->get();
                if (count($projectImages) > 0) {
                    foreach ($projectImages as $image) {
                        $image->delete();
                    }
                }
            }
            foreach ($params->project_images as $image) {
                $this->projectImagesRepository->save($image, $project->id);
            }
            DB::commit();
            return $project;
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
