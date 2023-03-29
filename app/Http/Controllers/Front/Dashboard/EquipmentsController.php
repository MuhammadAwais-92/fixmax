<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\EquipmentRepository;
use App\Http\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use App\Http\Dtos\AddEquipmentDto;
use App\Http\Requests\EquipmentRequest;

class EquipmentsController extends Controller
{
    protected $serviceRepository, $equipmentRepository;
    public function __construct(ServiceRepository $serviceRepository, EquipmentRepository $equipmentRepository)
    {
        parent::__construct();
        $this->serviceRepository = $serviceRepository;
        $this->serviceRepository->setFromWeb(true);
        $this->equipmentRepository = $equipmentRepository;
        $this->equipmentRepository->setFromWeb(true);

        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function index()
    {

    }
    public function create()
    {

    }
    public function edit($id)
    {



    }

    public function delete($id)
    {


    }
    public function save(EquipmentRequest $request, $id)
    {
     
    }
}
