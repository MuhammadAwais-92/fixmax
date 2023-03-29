<?php

namespace App\Http\Controllers\Api\supplier;

use App\Http\Controllers\Controller;
use App\Http\Dtos\AddServiceDto;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected object  $serviceRepository, $categoryRepository;

    public function __construct( ServiceRepository $serviceRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->serviceRepository = $serviceRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryRepository->setFromWeb(false);
        $this->serviceRepository->setFromWeb(false);

    }

    public function getSubcategories()
    {
        $user=$this->categoryRepository->getUser();
        $catId = $user->category->id;
        $this->categoryRepository->setRelations(['subCategories']);

        $this->categoryRepository->setSelect([
            'id',
            'name',
        ]);
        $categories = $this->categoryRepository->get($catId);

        if (!empty($categories)) {
            return responseBuilder()->success(__('Sub Categories'), ['SubCategories' => $categories]);
        }
        return responseBuilder()->error(__('Sub Categories Not Found'));
    }

    public function delete($id)
    {
        

        try {
            $service =  $this->serviceRepository->destroy($id);
            return responseBuilder()->success(__('Service deleted successfully.'));
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }

    }

    public function all(Request $request)
    {
        $this->serviceRepository->setPaginate(6);
        $this->serviceRepository->setRelations([
            'images:id,file_path,file_default,file_type,service_id',
            'category:id,name',
        ]);
        $services = $this->serviceRepository->all();
        foreach ($services as $service) {
            $service->getFormattedModel();
        }

        if (!empty($services)) {
            return responseBuilder()->success(__('services'),$services);
        }
        return responseBuilder()->error(__('services Not Found'));
    }

    public function save(ServiceRequest $request)
    {
        try {
            $addServiceDto = AddServiceDto::fromRequest($request);

            $service = $this->serviceRepository->save($addServiceDto);

            if ($request->id) {
                return responseBuilder()->success(__('service Updated Successfully'), ['Service' => $service->getFormattedModel()]);
            } else {
                return responseBuilder()->success(__('service Added Successfully'), ['Service' => $service->getFormattedModel()]);
            }
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->serviceRepository->getUser();
        $this->serviceRepository->setRelations([
            'images:id,file_path,file_default,file_type,service_id',
            'category',
            'category.parent',
            'userFeaturedSubscriptions',
        ]);
        $service = $this->serviceRepository->get($id);
        $activeFeaturedSubscription=$user->getUserActiveFeaturedPackages();
        if (!empty($service)) {
            return responseBuilder()->success(__('Service'), ['Service' => $service->getFormattedModel(),'activeFeaturedSubscription' => $activeFeaturedSubscription]);
        }
        return responseBuilder()->error(__('Service Not Found'));
    }

}
