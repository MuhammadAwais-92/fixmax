<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repositories\OrderRepository;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Exception;

class QuotationsController extends Controller
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->orderRepository = $orderRepository;
        $this->orderRepository->setFromAdmin(true);
        $this->breadcrumbTitle = 'Quotations';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Quotations'];
        return view('admin.quotations.index');
    }
    public function all()
    {

        $services = $this->orderRepository->allAdminQuotations();
        return response($services);
    }
    public function detail($id)
    {
        try {
            $this->breadcrumbs[route('admin.dashboard.quotations.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Quotations'];
            $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Quotation Detail'];
            $this->orderRepository->setRelations(['supplier.category', 'orderTransactions', 'orderItems', 'orderItems.equipment', 'service', 'user', 'service.equipments', 'service.supplier', 'service.supplier.category']);
            $quotation = $this->orderRepository->get($id);

            if (is_null($quotation)) {
                throw new Exception(__('Quotation not found'));
            }

            return view('admin.quotations.quotation-detail', ['quotation' => $quotation]);
        } catch (Exception $e) {
            return redirect(route('front.404'))->with('err', $e->getMessage());
        }
    }
    public function reject(Request $request, $id)
    {

        try {
            $request->merge(['status' => 'rejected', 'id' => $id]);
            $quotation = $this->orderRepository->reject($request);
            if ($quotation) {
                return response(['msg' => 'Quotation Cancelled successfully']);
            } else {
                return response(['err' => 'something went wrong'], 400);
            }
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()], 400);
        }
    }
}
