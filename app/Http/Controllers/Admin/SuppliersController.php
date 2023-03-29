<?php

namespace App\Http\Controllers\Admin;

use App\Http\Dtos\UserRegisterDto;
use App\Http\Dtos\UserSubscriptionSaveDto;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\SubscriptionPackageRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\UserSubscriptionRepository;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class SuppliersController extends Controller
{
    protected UserSubscriptionRepository $userSubscriptionRepository;
    protected SubscriptionPackageRepository $subscriptionPackageRepository;
    protected CityRepository $cityRepository;
    protected UserRepository $userRepository;
    protected CategoryRepository $categoryRepository;
    public function __construct(UserRepository $userRepository, CityRepository $cityRepository, CategoryRepository $categoryRepository, SubscriptionPackageRepository $subscriptionPackageRepository, UserSubscriptionRepository $userSubscriptionRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->userRepository = $userRepository;
        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
        $this->cityRepository = $cityRepository;
        $this->userSubscriptionRepository = $userSubscriptionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository->setFromWeb(true);
        $this->cityRepository->setFromWeb(true);
        $this->categoryRepository->setFromWeb(true);
        $this->subscriptionPackageRepository->setFromWeb(true);
        $this->userSubscriptionRepository->setFromWeb(true);
        $this->userSubscriptionRepository->setFromAdmin(true);
        $this->breadcrumbTitle = "Suppliers";
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->breadcrumbs[route('admin.dashboard.suppliers.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage suppliers'];
    }

    public function index()
    {
        return view('admin.suppliers.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'supplier_name', 'dt' => 'supplier_name'],
            ['db' => 'email', 'dt' => 'email'],
            ['db' => 'rating', 'dt' => 'rating'],
            ['db' => 'city_id', 'dt' => 'city_id'],
            ['db' => 'rating', 'dt' => 'rating'],
            ['db' => 'user_type', 'dt' => 'user_type'],
            ['db' => 'is_id_card_verified', 'dt' => 'is_id_card_verified'],
        ];
        $type = 'supplier';
        $store = $this->userRepository->adminDataTable($columns, $type);
        return response($store);
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Suppleir' : 'Add Supplier');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        $this->cityRepository->setSelect([
            'id',
            'name'
        ]);
        $this->cityRepository->setPaginate(0);
        $cities = $this->cityRepository->all(true);
        $this->categoryRepository->setSelect([
            'id',
            'name'
        ]);
        $categories = $this->categoryRepository->all(true);
        $this->subscriptionPackageRepository->setSelect([
            'id',
            'name',
        ]);
        $this->subscriptionPackageRepository->setPaginate(0);
        $packages = $this->subscriptionPackageRepository->all();
        $this->userRepository->setRelations(['city', 'subscription']);
        $user = $this->userRepository->get($id);

        $subscriptionId = 0;
        if ($id > 0) {
            $userSubscription = $user->subscription;
            if (isset($userSubscription->package)) {
                if (!$userSubscription->is_expired) {
                    $subscriptionId = $userSubscription->package['id'];
                }
            }
            if (is_null($user)) {
                return redirect(route('admin.stores.index'))->with('err', 'The selected store no longer exists.');
            }
        }

        return view('admin.suppliers.edit', [
            'method' => 'PUT',
            'action' => route('admin.dashboard.suppliers.update', $id),
            'heading' => $heading,
            'user' => $user,
            'cities' => $cities,
            'categories' => $categories,
            'packages' => $packages,
            'userSubscriptionId' => $subscriptionId
        ]);
    }
    public function reviews($id)
    {
        $heading = "Supplier Reviews";
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        $reivews = $this->userRepository->reviews($id);
        $store = User::find($id);
        if (count($reivews) < 1) {
            return redirect(route('admin.dashboard.suppliers.index'))->with('err', 'The selected Supplier has no reviews.');
        }


        return view('admin.suppliers.review', [
            'heading' => $heading,
            'reviews' => $reivews,
            'store' => $store,
        ]);

    }
    public function reviewsDelete($id)
    {
        try {
            $this->userRepository->Reviewsdestroy($id);
            return response(['msg' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()], 400);
        }
    }
    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if($request->estimated_time==null)
            {
                throw new Exception(__('Please Select atleast one area.'));
            }


            if (empty(array_filter($request->estimated_time, function ($a) {
                return $a !== null;
            }))) {
                throw new Exception(__('Please Select atleast one area.'));
            }
            $userDto = UserRegisterDto::fromRequest($request);
         
            $user = $this->userRepository->save($userDto);
            if ($userDto->package_id > 0) {
                $package = $this->subscriptionPackageRepository->get($userDto->package_id);
                $newUserSubscriptions = collect([
                    'user_subscription_package_id' => 0,
                    'user_id' => $user->id,
                    'package' => $package,
                    'is_expired' => false,
                    'payment_method' => 'admin',
                    'aed_price' => $package->price,
                    'currency' => 'AED',
                ]);
                $userSubscriptionDto = UserSubscriptionSaveDto::fromCollection($newUserSubscriptions);
                $this->userSubscriptionRepository->save($userSubscriptionDto);
            } else {
                if ($request->get('remove_package', 0)) {
                    $this->userSubscriptionRepository->removePackage($user);
                }
            }
            $this->submitCoveredAreas($request, $user->id);
            DB::commit();
            if ($id == 0) {
                return redirect(route('admin.dashboard.suppliers.index'))->with('status', 'Supplier added successfully');
            } else {
                return redirect(route('admin.dashboard.suppliers.index'))->with('status', 'Supplier updated successfully');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->userRepository->destroy($id);
            return response(['msg' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()], 400);
        }
    }

    public function idCardVerify($id)
    {
        try {
            $user = $this->userRepository->verifyIdCard($id);
            if ($user->isSupplier()) {
                return redirect(route('admin.dashboard.suppliers.index'))->with('status', 'Id card image is Verified.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }
    public function submitCoveredAreas($request, $userId)
    {
        try {
            $udateValue = [];
            if (!empty($request->coveredAreaId)) {
                $udateValue = count($request->coveredAreaId);

                $ids = $request->coveredAreaId;
                $cityIds = $request->area;
                $estimated_time = $request->estimated_time;
                $data = [];
                $i = 0;
                foreach ($ids as $keyd => $id) {
                    foreach ($cityIds as $key =>  $cityId) {
                        foreach ($estimated_time as $keys => $time) {
                            if ($keyd == $key && $key == $keys && $time != null && $time !== '0') {
                                $data[$i] = [
                                    'id'    => $id,
                                    'city_id' => $cityId,
                                    'estimated_time' => $time,
                                    'user_id' => $userId,
                                ];
                                break;
                            }
                        }
                        $i++;
                    }
                }
                $user = User::find($userId);
                $user->coveredAreas()->detach(array_column($data, 'city_id'));
                $user->coveredAreas()->sync($data);
            }
            $cityIds = $request->area;
            $estimated_time = $request->estimated_time;
            if ($request->coveredAreaId) {
                for ($c = 0; $c < $udateValue; $c++) {
                    unset($cityIds[$c]);
                    unset($estimated_time[$c]);
                }
            }
            $data = [];
            $i = 0;
            foreach ($cityIds as $key =>  $cityId) {
                foreach ($estimated_time as $keys => $time) {
                    if ($key == $keys && $time != null && $time !== '0') {
                        $data[$i] = [
                            'city_id' => $cityId,
                            'estimated_time' => $time,
                            'user_id' => $userId,
                        ];
                        break;
                    }
                }
                $i++;
            }

            $user = User::find($userId);
            $user->coveredAreas()->attach($data);



            // $cityIds = $request->area;
            // $estimated_time = $request->estimated_time;
            // $data = [];
            // $i = 0;
            // foreach ($cityIds as $key =>  $cityId) {
            //     foreach ($estimated_time as $keys => $time) {
            //         if ($key == $keys && $time != null && $time !== '0') {
            //             $data[$i] = [
            //                 'city_id' => $cityId,
            //                 'estimated_time' => $time,
            //                 'user_id' => $id,
            //             ];
            //             break;
            //         }
            //     }
            //     $i++;
            // }
            // $user = User::find($id);
            // $user->coveredAreas()->attach($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
}
