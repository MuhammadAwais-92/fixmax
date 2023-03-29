<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CityRepository;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\User;
use App\Models\UserArea;

use Exception;

class CoveredAreasController extends Controller
{
  public CityRepository $cityRepository;
  public function __construct()
  {
    parent::__construct('adminData', 'admin');
    $this->breadcrumbTitle = 'Cities';
    $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    $this->cityRepository = new CityRepository();
  }
  public function getAreas($id, $userId = null)
  {

    $this->cityRepository->setRelations(['areas']);
    $this->cityRepository->setSelect([
      'id',
      'name',
    ]);
    $city = $this->cityRepository->get($id);

    $coveredAreas = UserArea::where('user_id', $userId)->with('area')->get();
    $coveredAreasArray = $coveredAreas->toArray();
    $coveredAreasIds = array_column($coveredAreasArray, 'city_id');
    $cityAreas = $city->areas->toArray();
    $cityAreasIds = array_column($cityAreas, 'id');
    $additionalFields = array_diff($cityAreasIds, $coveredAreasIds);
    $areaHtml = '';

    foreach ($coveredAreas as $area) {
      if ($area->area) {
        $areaHtml .= '<div class="select-city-areas">
                    <div class="accordion" id="accordionExample">
                      <div class="card-city">        
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="inner-city">
                            <div class="city-list-input d-flex align-items-center justify-content-between">
                              <div class="city-name">
                              ' . translate($area->area->name) . '
                              </div>
                              <input type="text" hidden name="coveredAreaId[]" value="' . $area->id . '" >
                              <input type="text" hidden name="area[]" value="' . $area->city_id . '">
                              <div class="city-input w-100">
                                <div class="common-input-border">
                                  <input type="number" min="1"  oninput="" value="' . $area->estimated_time . '"
                                  name="estimated_time[]" placeholder="' . __('e.g 50 mins') . '">
                                </div>
                              </div>
                              <a href="' . route('admin.dashboard.covered.areas.delete', [$area->area->id, $userId]) . '"
                              class="edit-del-btn">
                              <i class="fas fa-trash-alt"></i>
                          </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
      }
    }

    if (!empty($additionalFields)) {

      foreach ($city->areas as $area) {
        if (in_array($area->id, $additionalFields)) {
          $areaHtml .= ' <div class="select-city-areas">
            <div class="accordion" id="accordionExample">
              <div class="card-city">        
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="inner-city">
                    <div class="city-list-input d-flex align-items-center justify-content-between">
                      <div class="city-name">
                      ' . translate($area->name) . '
                      </div>
                      <input type="text" hidden name="area[]" value="' . $area->id . '">
                      <div class="city-input w-100">
                        <div class="common-input-border">
                          <input type="number" min="1" max="60" oninput=""
                          name="estimated_time[]" placeholder="' . __('e.g 50 mins') . '">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>';
        }
      }
    }
    return response(['status_code' => '200', 'message' => 'Image uploaded successfully.', 'data' =>  $areaHtml]);
  }
  public function deleteCoveredArea($cityId, $userId)
  {
    try {
      $user = User::find($userId);
      $user->coveredAreas()->detach($cityId);

      return redirect()->back()->with('status', 'Covered Area is deleted Successfully.');
    } catch (\Exception $e) {
      return redirect()->back()->with('err', $e->getMessage())->withInput();
    }
  }
}
