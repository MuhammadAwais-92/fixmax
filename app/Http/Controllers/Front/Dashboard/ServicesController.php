<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Dtos\AddServiceDto;
use App\Http\Requests\ServiceRequest;

class ServicesController extends Controller
{

    protected $serviceRepository, $categoryRepository;
    public function __construct(ServiceRepository $serviceRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->serviceRepository = $serviceRepository;
        $this->categoryRepository = $categoryRepository;
        $this->serviceRepository->setFromWeb(true);
        $this->categoryRepository->setFromWeb(true);

        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function index()
    {
    }
    public function featuredServices()
    {

    }
    public function edit($id)
    {

    }
    public function create()
    {

    }
    public function delete($id)
    {

    }
    public function save(ServiceRequest $request, $id)
    {
        
    }
}
