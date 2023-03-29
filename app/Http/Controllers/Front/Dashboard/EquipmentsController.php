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
        $this->breadcrumbTitle = __('Manage Equipments');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Manage Equipments')];
        $this->equipmentRepository->setPaginate(6);
        $this->equipmentRepository->setRelations(['service']);
        $equipments = $this->equipmentRepository->all();
        foreach ($equipments as $equipment) {
            $equipment->getFormattedModel();
        }
        return view(
            'front.dashboard.equipments.manage-equipment',
            [
                'equipments' => $equipments
            ]
        );
    }
    public function create()
    {
        $this->breadcrumbTitle = __('Manage Equipments');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Manage Equipments')];



        $this->serviceRepository->setSelect([
            'id',
            'name',
        ]);
        $services = $this->serviceRepository->all();
        $equipment = $this->equipmentRepository->getModel();
        return view(
            'front.dashboard.equipments.edit-equipment',
            [
                'equipment' => $equipment,
                'services' => $services
            ]
        );
    }
    public function edit($id)
    {


        $this->breadcrumbTitle = __('Edit Equipments');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Edit Equipment')];
        $this->serviceRepository->setSelect([
            'id',
            'name',
        ]);
        $services = $this->serviceRepository->all();

        $equipment = $this->equipmentRepository->get($id);
        return view('front.dashboard.equipments.edit-equipment', [
            'services' => $services,
            'equipment' => $equipment
        ]);
    }

    public function delete($id)
    {
        $equipment =  $this->equipmentRepository->destroy($id);;
        if ($equipment) {
            return redirect()->back()->with('status', __('Equipment deleted successfully.'));
        }
        return redirect()->back()->with('err', __('Something went wrong'));

    }
    public function save(EquipmentRequest $request, $id)
    {
        try {
            $addEquipmentDto = AddEquipmentDto::fromRequest($request);
            $this->equipmentRepository->save($addEquipmentDto);
            if ($request->id != null) {
                session()->flash('status', __('Equipment updated successful.'));
            } else {
                session()->flash('status', __('Equipment created successful.'));
            }
            return redirect(route('front.dashboard.equipments.index'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
}
