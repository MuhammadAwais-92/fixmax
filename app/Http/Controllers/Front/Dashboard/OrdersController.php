<?php

namespace App\Http\Controllers\Front\Dashboard;



use App\Http\Controllers\Controller;

use App\Http\Repositories\OrderRepository;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;


use Exception;

class OrdersController extends Controller
{


    protected object $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->orderRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function quotationIndex($status = 'all')
    {

        $user = $this->user;
        if ($user->isSupplier()) {
            $this->breadcrumbTitle = __('Manage Quotations');
            $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Manage Quotations')];
        }
        $user_id = 0;
        $supplier_id = 0;
        if ($user->isUser()) {
            $user_id = $user->id;
            $this->breadcrumbTitle = __('Quotations');
            $this->breadcrumbs['javascript: {};'] = ['title' => __('Quotations')];
        }
        if ($user->isSupplier()) {
            $supplier_id = $user->id;
        }
        $this->orderRepository->setPaginate(5);
        $this->orderRepository->setRelations(['orderTransactions', 'orderItems', 'service']);
        $quotations = $this->orderRepository->all($status, $user_id, $supplier_id);
        return view('front.dashboard.quotations.manage-quotations', ['quotations' => $quotations, 'status' => $status]);
    }
    public function ordersIndex($status = 'all')
    {

        $user = $this->user;
        if ($user->isSupplier()) {
            $this->breadcrumbTitle = __('Manage Orders');
            $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Manage Orders')];
        }
        $user_id = 0;
        $supplier_id = 0;
        if ($user->isUser()) {
            $user_id = $user->id;
            $this->breadcrumbTitle = __('My Orders');
            $this->breadcrumbs['javascript: {};'] = ['title' => __('My Orders')];
        }
        if ($user->isSupplier()) {
            $supplier_id = $user->id;
        }
        $this->orderRepository->setPaginate(5);
        $this->orderRepository->setRelations(['orderTransactions', 'orderItems', 'service']);
        $orders = $this->orderRepository->ordersall($status, $user_id, $supplier_id);
        return view('front.dashboard.orders.manage-orders', ['orders' => $orders, 'status' => $status]);
    }
    public function quotationDetail($id)
    {
        try {
            $user = $this->user;
            $this->breadcrumbTitle = __('Quotation Details');
            if ($user->isUser()) {
                $this->breadcrumbs[] = ['url' => route('front.dashboard.quotations.index'), 'title' => __('Quotations')];
            } else {
                $this->breadcrumbs[] = ['url' => route('front.dashboard.quotations.index'), 'title' => __('Manage Quotations')];
            }
            $this->breadcrumbs[] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Quotation Details')];

            $user_id = 0;
            $supplier_id = 0;
            if ($user->isUser()) {
                $user_id = $user->id;
            }
            if ($user->isSupplier()) {
                $supplier_id = $user->id;
            }
            $this->orderRepository->setRelations(['orderTransactions', 'orderItemsToBeBought', 'orderItemsBought', 'serviceRating', 'orderItems', 'orderItems.equipment', 'service', 'user', 'service.equipments', 'service.supplier', 'service.supplier.category']);
            $quotation = $this->orderRepository->getQuotationSummary($id);
            $quotedContent = $this->orderRepository->getCheckoutContent($id);
            $order = $this->orderRepository->get($id, $user_id, $supplier_id);
            if (is_null($quotation)) {
                throw new Exception(__('Quotation not found'));
            }
            return view('front.dashboard.quotations.quotation-detail', ['quotation' => $quotation, 'quotedContent' => $quotedContent, 'order' => $order]);
        } catch (Exception $e) {
            return redirect(route('front.404'))->with('err', $e->getMessage());
        }
    }
    public function orderDetail($id)
    {
        try {
            $user = $this->user;
            $this->breadcrumbTitle = __('Order Detail');
            if ($user->isUser()) {
                $this->breadcrumbs[] = ['url' => route('front.dashboard.orders.index'), 'title' => __('Orders')];
            } else {
                $this->breadcrumbs[] = ['url' => route('front.dashboard.orders.index'), 'title' => __('Manage Orders')];
            }
            $this->breadcrumbs[] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Order Details')];

            $user_id = 0;
            $supplier_id = 0;
            if ($user->isUser()) {
                $user_id = $user->id;
            }
            if ($user->isSupplier()) {
                $supplier_id = $user->id;
            }
            $this->orderRepository->setRelations(['rateSupplier' => function ($q) use ($user_id) {
                $q->select(['id', 'supplier_id', 'user_id', 'service_id', 'order_id', 'rating', 'review', 'is_reviewed'])->where('service_id', false)->where('user_id', $user_id);
            }, 'rateService' => function ($q) use ($user_id) {
                $q->select(['id', 'supplier_id', 'user_id', 'service_id', 'order_id', 'rating', 'review', 'is_reviewed'])->where('supplier_id', false)->where('user_id', $user_id);
            }, 'orderTransactions', 'orderItemsToBeBought', 'serviceRating', 'orderItems', 'orderItems.equipment', 'service', 'user', 'service.equipments', 'service.supplier', 'service.supplier.category']);
            $order = $this->orderRepository->get($id, $user_id, $supplier_id);
            $order->vat = $order->vat_1 + $order->vat_2;
            if (is_null($order)) {
                throw new Exception(__('Order not found'));
            }
            return view('front.dashboard.orders.order-details', ['order' => $order]);
        } catch (Exception $e) {
            return redirect(route('front.404'))->with('err', $e->getMessage());
        }
    }
    public function checkoutContent($quotationId)
    {
        $this->breadcrumbTitle = __('Checkout');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Checkout')];
        $this->orderRepository->setRelations([
            'service',
            'service.supplier',
            'user',
            'user.addresses',
            'orderItems',
            'orderItemsToBeBought'
        ]);
        $checkoutContent = $this->orderRepository->getCheckoutContent($quotationId);
        return view('front.checkout.checkout2', ['checkoutContent' => $checkoutContent]);
    }
    public function visit(OrderRequest $request)
    {
        try {
            $this->orderRepository->visit($request);
            return redirect()->back()->with('status', __('Quotation Visited Successfully.'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
    // Quotation reject
    public function reject(OrderRequest $request)
    {
        try {
            $this->orderRepository->reject($request);
            return redirect()->back()->with('status', __('Quotation Rejected Successfully.'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
    // Quotation responded
    public function quote(OrderRequest $request)
    {
        try {
            $this->orderRepository->quote($request);
            return redirect()->back()->with('status', __('Quotation Responded Successfully.'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
    // Order Cancel
    public function cancelOrder(OrderRequest $request)
    {
        try {
            $this->orderRepository->orderCancel($request);
            return redirect()->back()->with('status', __('Order Cancelled Successfully.'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
    // Order In Progress
    public function inProgress(OrderRequest $request)
    {
        try {
            $this->orderRepository->inProgress($request);
            return redirect()->back()->with('status', __('Order is In Progress Successfully.'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
    // Order Complete
    public function complete(OrderRequest $request)
    {
        try {
            $this->orderRepository->complete($request);
            return redirect()->back()->with('status', __('Order is Completed Successfully.'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
}
