<?php

namespace App\Http\Controllers\Front\Dashboard;


use App\Http\Repositories\CityRepository;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CoveredAreasRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\CoveredAreaRequest;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoveredAreaController extends Controller
{

    protected UserRepository $userRepository;
    protected CityRepository $cityRepository;
    protected CoveredAreasRepository $coveredAreaRepository;



    public function __construct(UserRepository $userRepository, CityRepository $cityRepository, CoveredAreasRepository $coveredAreaRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->userRepository->setFromWeb(true);
        $this->cityRepository = $cityRepository;
        $this->cityRepository->setFromWeb(true);
        $this->coveredAreaRepository = $coveredAreaRepository;
        $this->coveredAreaRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function coveredAreasForm()
    {
        $this->breadcrumbTitle = __('Select Service Area');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Select Service Area')];
        $this->cityRepository->setRelations(['areas']);
        $this->cityRepository->setSelect([
            'id',
            'name',
        ]);
        $city = $this->cityRepository->get($this->user->city_id);


        return view('front.auth.area-form', [
            'city' => $city
        ]);
    }
    public function submitCoveredAreas(Request $request)
    {
        try {
            $coveredAreas = array_filter($request->covered_areas, function ($var) {
                return (isset($var['estimated_time']) && !empty($var['estimated_time']));
            });
            if (count($coveredAreas) <= 0) {
                return redirect()->back()->with('err', 'Please Select atleast one area');
            }

            $result = $this->coveredAreaRepository->save($coveredAreas);
            if ($result == 'updated') {
                return redirect()->back()->with('status', 'Area is Updated Successfully.');
            }
            session()->flash('status', __('Area Selection is Successfully.'));
            return redirect(route('front.dashboard.index'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function deleteCoveredArea($cityId)
    {
        try {
            $this->user->coveredAreas()->detach($cityId);

            return redirect()->back()->with('status', 'Covered Area is deleted Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
}
