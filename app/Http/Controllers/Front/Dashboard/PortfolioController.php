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
    }
    public function create()
    {

    }
    public function detail($id)
    {
    }
    public function edit($id)
    {


    }
    public function save(ProjectRequest $request, $id)
    {

    }
    public function delete($id)
    {
       

    }
}
