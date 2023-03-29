<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repositories\OrderRepository;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Exception;
class OrdersController extends Controller
{
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->orderRepository = $orderRepository;
        $this->orderRepository->setFromAdmin(true);
        $this->breadcrumbTitle = 'Orders';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Orders'];
        return view('admin.orders.index');
    }
    public function all()
    {
     
        $services = $this->orderRepository->allAdminOrders();
        return response($services);
    }
    public function detail($id)
    {
        try {
            $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-user', 'title' => 'Order Detail'];
            $this->orderRepository->setRelations(['supplier.category','orderTransactions','orderItems','orderItems.equipment','service','user','service.equipments','service.supplier','service.supplier.category']);
            $order = $this->orderRepository->get($id);
       
            if (is_null($order)){
                throw new Exception(__('order not found'));
            }
            $order->vat=$order->vat_1+$order->vat_2;
            return view('admin.orders.order-detail',['order'=>$order]);
        }catch (Exception $e){
            return redirect(route('front.404'))->with('err',$e->getMessage());
        }
    }
    public function cancel(Request $request,$id)
    {

        try {
            $request->merge(['status' => 'cancelled','id' => $id]);
             $quotation = $this->orderRepository->orderCancel($request);
            if($quotation){
                return response(['msg' => 'Quotation Cancelled successfully']);
            }else{
                return response(['err' => 'something went wrong'],400);
            }

       } catch (\Exception $e) {
           return response(['err' => $e->getMessage()],400);
       }
    }
}
