<?php

namespace App\Http\Controllers\Api;


use App\Http\Repositories\CityRepository;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CoveredAreasRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoveredAreasController extends Controller
{
    protected UserRepository $userRepository;
    protected CityRepository $cityRepository;
    protected CoveredAreasRepository $coveredAreaRepository;
    public function __construct(UserRepository $userRepository, CityRepository $cityRepository, CoveredAreasRepository $coveredAreaRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->userRepository->setFromWeb(false);
        $this->cityRepository = $cityRepository;
        $this->cityRepository->setFromWeb(false);
        $this->coveredAreaRepository = $coveredAreaRepository;
        $this->coveredAreaRepository->setFromWeb(false);
    }
    public function cityAreas()
    {
        $this->cityRepository->setRelations(['areas']);
        $this->cityRepository->setSelect([
            'id',
            'name',
        ]);
        $user = auth()->user();
        $city = $this->cityRepository->get($user->city_id);
        return responseBuilder()->success(__('city areas'), ['city-areas' => $city]);
    }
    public function submitCoveredAreas(Request $request)
    {
        try {
            $coveredAreas = array_filter($request->covered_areas, function ($var) {
                return (isset($var['estimated_time']) && !empty($var['estimated_time']));
            });
            if (count($coveredAreas) <= 0) {
                return responseBuilder()->error(__('please select atleast one area'));
            }
            $result = $this->coveredAreaRepository->save($coveredAreas);

            if ($result == 'updated') {
                return responseBuilder()->success(__('Area is Updated Successful'));
            }
            return responseBuilder()->success(__('Area Selection is Successful.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function deleteCoveredArea($cityId) {
        try {
            auth()->user()->coveredAreas()->detach($cityId);

            return responseBuilder()->success(__('Covered Area is deleted Successfully.'));

        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
}
