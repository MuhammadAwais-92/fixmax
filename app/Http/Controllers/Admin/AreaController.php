<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CityRepository;
use App\Http\Requests\CityRequest;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public CityRepository $cityRepository;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Cities';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->cityRepository = new CityRepository();
    }


    public function edit($parentId, $id)
    {
        $city = $this->cityRepository->get($parentId);
        $this->breadcrumbTitle = $city->name['en'];
        $heading = (($id > 0) ? 'Edit Area' : 'Add Area');
        $this->breadcrumbs[route('admin.dashboard.cities.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Cities'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        $area = $this->cityRepository->get($id);
        return view('admin.areas.edit', [
            'cityId' => $id,
            'city' =>  $this->getViewParamsArea($area),
            'action' => route('admin.dashboard.cities.areas.update', [$parentId, $id]),
            'parent' => $parentId
        ]);
    }
    private function getViewParamsArea($area)
    {

        if (is_null($area->polygon)) {
            $area->polygon = json_encode([]);
        } else {
            $area->polygon = json_encode($area->polygon);
        }

        return $area;
    }

    public function update(CityRequest $request, $parentId, $id)
    {
        try {
            $data = $request->except('_method', '_token');
            $data['polygon'] = json_decode($request->polygon);
            $city = $this->cityRepository->save($data, $id);
            if ($id == 0) {
                return redirect(route('admin.dashboard.cities.index'))->with('status', 'Area is Added Successfully.');
            } else {
                return redirect(route('admin.dashboard.cities.index'))->with('status', 'Area is Updated Successfully.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->cityRepository->destroy($id);
        return response(['msg' => 'Area is Deleted Successfully.']);
    }
}
