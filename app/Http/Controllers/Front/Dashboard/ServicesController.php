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
        $this->breadcrumbTitle = __('Manage Services');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Manage Services')];
        $this->serviceRepository->setPaginate(12);
        $this->serviceRepository->setRelations([
            'images:id,file_path,file_default,file_type,service_id',
        ]);
        $services = $this->serviceRepository->all();
        foreach ($services as $service) {
            $service->getFormattedModel();
        }
        return view(
            'front.dashboard.services.manage-service',
            [
                'services' => $services,
            ]
        );
    }
    public function featuredServices()
    {
        $this->breadcrumbTitle = __('Featured Services');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Featured Services')];
        $this->serviceRepository->setPaginate(6);
        $this->serviceRepository->setRelations([
            'images:id,file_path,file_default,file_type,service_id',
        ]);
        $services = $this->serviceRepository->all('featured');

        foreach ($services as $service) {
            $service->getFormattedModel();
        }
        return view(
            'front.dashboard.services.manage-featured-services',
            [
                'services' => $services,
            ]
        );
    }
    public function edit($id)
    {
        $user = auth()->user();
        if ($user->isSupplier()) {
            if (!$user->isApproved()) {
                return redirect(route('front.dashboard.stadium.index'))->with('err', __('Your ID Card is not verified by the admin. You can not edit any stadium until your ID is verified by the admin.'));
            }
        }

        $this->breadcrumbTitle = __('Edit Services');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Edit Service')];
        $catId = $user->category->id;
        $this->categoryRepository->setRelations(['subCategories']);

        $this->categoryRepository->setSelect([
            'id',
            'name',
        ]);
        $categories = $this->categoryRepository->get($catId);
        $this->serviceRepository->setRelations([
            'images:id,file_path,file_default,file_type,service_id',
        ]);
        $service = $this->serviceRepository->get($id);
        $activeFeaturedSubscription = $this->user->getUserActiveFeaturedPackages();
        return view('front.dashboard.services.edit-service', [
            'service' => $service,
            'category' => $categories,
            'activeFeaturedSubscription' => $activeFeaturedSubscription,
        ]);
    }
    public function create()
    {
        $this->breadcrumbTitle = __('Add Service');
        $this->breadcrumbs[] = ['url' => route('front.dashboard.services.index'), 'title' => __('Manage Services')];

        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Add Service')];
        $catId = $this->user->category->id;
        $this->categoryRepository->setRelations(['subCategories']);

        $this->categoryRepository->setSelect([
            'id',
            'name',
        ]);
        $categories = $this->categoryRepository->get($catId);
        $service = $this->serviceRepository->getModel();
        $activeFeaturedSubscription = $this->user->getUserActiveFeaturedPackages();
        return view(
            'front.dashboard.services.edit-service',
            [
                'service' => $service,
                'category' => $categories,
                'activeFeaturedSubscription' => $activeFeaturedSubscription,
            ]
        );
    }
    public function delete($id)
    {
        try {
            $service =  $this->serviceRepository->destroy($id);
            if ($service) {
                return redirect()->back()->with('status', __('Service deleted successfully.'));
            }
            return redirect()->back()->with('err', __('Something went wrong'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function save(ServiceRequest $request, $id)
    {
        try {
            $addServiceDto = AddServiceDto::fromRequest($request);
            $this->serviceRepository->save($addServiceDto);
            if ($request->id != null) {
                session()->flash('status', __('Service updated successful.'));
            } else {
                session()->flash('status', __('Service created successful.'));
            }
            return redirect(route('front.dashboard.services.index'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
}
