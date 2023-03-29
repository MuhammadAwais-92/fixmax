<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Dtos\SubscriptionUpdateDto;
use App\Http\Libraries\DataTable;
use App\Http\Repositories\SubscriptionPackageRepository;
use App\Http\Requests\FromValidation;
use App\Http\Requests\SubscriptionPackageRequest;
use App\Models\SubscriptionPackage;

class SubscriptionController extends Controller
{

    protected $subscriptionPackageRepository;

    public function __construct(SubscriptionPackageRepository $subscriptionPackageRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Subscription Packages';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
      

        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Subscription & Feature Packages'];
        $this->breadcrumbTitle = 'Subscription & Feature Packages';
        return view('admin.subscription.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'name', 'dt' => 'name'],
            ['db' => 'duration', 'dt' => 'duration'],
            ['db' => 'duration_type', 'dt' => 'duration_type'],
            ['db' => 'price', 'dt' => 'price'],
            ['db' => 'subscription_type', 'dt' => 'subscription_type'],
            ['db' => 'description', 'dt' => 'description'],
        ];

        $packages = $this->subscriptionPackageRepository->adminDataTable($columns);

        return response($packages);
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Subscription Package' : 'Add Subscription Package');
        $this->breadcrumbs[route('admin.dashboard.subscriptions.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Packages'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
//        dd($this->subscriptionPackageRepository->get($id));
        return view('admin.subscription.edit', [
            'method' => 'PUT',
            'packageId' => $id,
            'action' => route('admin.dashboard.subscriptions.update', $id),
            'heading' => $heading,
            'package' => $this->subscriptionPackageRepository->get($id)
        ]);
    }

    public function update(SubscriptionPackageRequest $request, $id)
    {
        try {
            $subscriptionDto = SubscriptionUpdateDto::fromRequest($request);
            $this->subscriptionPackageRepository->save($subscriptionDto);
            if ($id == 0) {
                return redirect(route('admin.dashboard.subscriptions.index'))->with('status', 'Package added successfully.');
            } else {
                return redirect(route('admin.dashboard.subscriptions.index'))->with('status', 'Package updated successfully.');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }

    }

    public function destroy($id)
    {
        try {
            $this->subscriptionPackageRepository->destroy($id);
            return response(['msg' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()],400);
        }
    }
}