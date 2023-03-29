<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FromValidation;
use App\Http\Repositories\CouponRepository;

class CouponController extends Controller
{

    protected $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->couponRepository = $couponRepository;
        $this->breadcrumbTitle = 'Coupons';

        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Coupons'];
        return view('admin.coupons.index');
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'name', 'dt' => 'name'],
            ['db' => 'coupon_code', 'dt' => 'coupon_code'],
            ['db' => 'discount', 'dt' => 'discount'],
            ['db' => 'end_date', 'dt' => 'end_date'],
            ['db' => 'status', 'dt' => 'status'],
            ['db' => 'coupon_type', 'dt' => 'coupon_type'],
            ['db' => 'coupon_number', 'dt' => 'coupon_number'],
            ['db' => 'created_at', 'dt' => 'created_at'],
            ['db' => 'updated_at', 'dt' => 'updated_at'],
            ['db' => 'deleted_at', 'dt' => 'deleted_at'],
        ];
        $count = 0;
        $type = 'store';
        $category = $this->couponRepository->all($columns, $count, $type);

        return response($category);
    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Coupon' : 'Add Coupon');
        $this->breadcrumbs[route('admin.dashboard.coupons.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Coupons'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];


        if (is_null($this->couponRepository->getViewParams($id))) {
            return redirect(route('admin.dashboard.coupons.index'))->with('err', 'The selected Coupons no longer exists.');
        }

        return view('admin.coupons.edit', [
            'method'   => 'PUT',
            'couponId' => $id,
            'action'   => route('admin.dashboard.coupons.update', ['id' => $id]),
            'heading'  => $heading,
            'coupon'   => $this->couponRepository->getViewParams($id),

        ]);
    }


    public function update($id, Request $request)
    {
        try {
            $this->couponRepository->save($request, $id);
            if (empty($id)) {
                return redirect(route('admin.dashboard.coupons.index'))->with('status', 'Coupon added successfully.');
            }
            return redirect(route('admin.dashboard.coupons.index'))->with('status', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->couponRepository->destroy($id);
            return response(['msg' => 'Successfully deleted']);
        } catch (\Exception $e) {
            return response(['err' => 'Unable to delete'], 400);
        }
    }
}
