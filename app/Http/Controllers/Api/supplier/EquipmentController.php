<?php

namespace App\Http\Controllers\Api\supplier;

use App\Http\Controllers\Controller;
use App\Http\Dtos\AddEquipmentDto;
use App\Http\Repositories\EquipmentRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Requests\EquipmentRequest;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    protected object  $serviceRepository, $categoryRepository;

    public function __construct( ServiceRepository $serviceRepository,EquipmentRepository $equipmentRepository)
    {
        parent::__construct();
        $this->serviceRepository = $serviceRepository;
        $this->equipmentRepository = $equipmentRepository;
        $this->equipmentRepository->setFromWeb(false);
        $this->serviceRepository->setFromWeb(false);

    }



    public function delete($id)
    {


        try {
            $equipment =  $this->equipmentRepository->destroy($id);
            return responseBuilder()->success(__('Equipment deleted successfully.'));
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }

    }

    public function all(Request $request)
    {
        $this->equipmentRepository->setPaginate(6);
        $this->equipmentRepository->setRelations([
            'service:id,name',
        ]);
        $equipments = $this->equipmentRepository->all();
        foreach ($equipments as $equipment) {
            $equipment->getFormattedModel();
        }

        if (!empty($equipments)) {
            return responseBuilder()->success(__('equipments'), $equipments);
        }
        return responseBuilder()->error(__('equipments Not Found'));
    }

    public function save(EquipmentRequest $request)
    {
        try {
            $addEquipmentDto = AddEquipmentDto::fromRequest($request);

            $equipment = $this->equipmentRepository->save($addEquipmentDto);

            if ($request->id) {
                return responseBuilder()->success(__('equipment Updated Successfully'), ['equipment' => $equipment->getFormattedModel()]);
            } else {
                return responseBuilder()->success(__('equipment Added Successfully'), ['equipment' => $equipment->getFormattedModel()]);
            }
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->equipmentRepository->setRelations([
            'service:id,name'
        ]);


        $equipment = $this->equipmentRepository->get($id);
        if (!empty($equipment)) {
            return responseBuilder()->success(__('Equipment'), ['Equipment' => $equipment->getFormattedModel()]);
        }
        return responseBuilder()->error(__('Equipment Not Found'));
    }

}
