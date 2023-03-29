<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;

use App\Http\Repositories\OrderRepository;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends Controller
{

    protected object $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->orderRepository->setFromWeb(false);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function quotationIndex($status = 'all')
    {

        $user = auth()->user();
        $user_id = 0;
        $supplier_id = 0;
        if ($user->isUser()) {
            $user_id = $user->id;
        }
        if ($user->isSupplier()) {
            $supplier_id = $user->id;
        }
        $this->orderRepository->setPaginate(5);
        $this->orderRepository->setRelations(['orderTransactions', 'orderItems', 'service']);
        $quotations = $this->orderRepository->all($status, $user_id, $supplier_id);
        return responseBuilder()->success(__('quotations'), $quotations);
    }
    public function ordersIndex($status = 'all')
    {

        $user = auth()->user();
        $user_id = 0;
        $supplier_id = 0;
        if ($user->isUser()) {
            $user_id = $user->id;
        }
        if ($user->isSupplier()) {
            $supplier_id = $user->id;
        }
        $this->orderRepository->setPaginate(5);
        $this->orderRepository->setRelations(['orderTransactions', 'orderItems', 'service']);
        $orders = $this->orderRepository->ordersall($status, $user_id, $supplier_id);
        return responseBuilder()->success(__('orders'), $orders);
    }
    public function checkoutContent($quotationId)
    {
        $this->orderRepository->setRelations([
            'service',
            'supplier',
            'user',
            'user.addresses',
            'orderItems.equipment'
        ]);
        $checkoutContent = $this->orderRepository->getCheckoutContent($quotationId);
        return responseBuilder()->success(__('service-checkout content'), ['checkout data' => $checkoutContent]);
    }
    public function quotationDetail($id)
    {
        try {
            $user = auth()->user();
            $user_id = 0;
            $supplier_id = 0;
            if ($user->isUser()) {
                $user_id = $user->id;
            }
            if ($user->isSupplier()) {
                $supplier_id = $user->id;
            }
            $this->orderRepository->setRelations(['orderTransactions', 'orderItemsToBeBought','orderItemsBought','orderItems', 'orderItems.equipment', 'service', 'user', 'service.supplier', 'service.supplier.category']);
            $quotation = $this->orderRepository->getQuotationSummary($id);
            $quotedContent = $this->orderRepository->getCheckoutContent($id);
            $quotedContent->date=$quotation->date;
            $quotation->first_checkout_payment_method = $quotation->orderTransactions->first()->payment_method;
            $quotation->second_checkout_payment_method = $quotation->orderTransactions->skip(1)->first() ? $quotation->orderTransactions->skip(1)->first()->payment_method : '';
            if (is_null($quotation)) {
                throw new Exception(__('Quotation not found'));
            }
            return responseBuilder()->success(__('quotation detail'), ['quotation' => $quotation,'quotedContent'=>$quotedContent]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function orderDetail($id)
    {
        try {
            $user = auth()->user();

            $user_id = 0;
            $supplier_id = 0;
            if ($user->isUser()) {
                $user_id = $user->id;
            }
            if ($user->isSupplier()) {
                $supplier_id = $user->id;
            }
            $this->orderRepository->setRelations(['orderTransactions', 'orderItems', 'orderItems.equipment', 'service', 'user', 'service.equipments', 'service.supplier', 'service.supplier.category', 'service.pendingReviews'=>function($q) use($user_id){
                $q->select(['id','user_id','service_id','rating','review','is_reviewed'])->where('user_id', $user_id);
            },'supplier.pendingReviews'=>function($q) use($user_id){
                $q->select(['id','user_id','service_id','supplier_id','rating','review','is_reviewed'])->where('user_id', $user_id);
            }]);
            $order = $this->orderRepository->get($id, $user_id, $supplier_id);
            $order->first_checkout_payment_method = $order->orderTransactions->first()->payment_method;
            $order->second_checkout_payment_method = $order->orderTransactions->skip(1)->first() ? $order->orderTransactions->skip(1)->first()->payment_method : '';
            $order->vat = $order->vat_1 + $order->vat_2;
            if (is_null($order)) {
                throw new Exception(__('Order not found'));
            }
            return responseBuilder()->success(__('order detail'), ['order' => $order]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function visit(OrderRequest $request)
    {
        try {
            $this->orderRepository->visit($request);
            return responseBuilder()->success(__('Quotation Visited Successfully.'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    // Quotation reject
    public function reject(OrderRequest $request)
    {
        try {
            $this->orderRepository->reject($request);
            return responseBuilder()->success(__('Quotation Rejected Successfully.'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    // Quotation responded
    public function quote(OrderRequest $request)
    {
        try {
            $this->orderRepository->quote($request);
            return responseBuilder()->success(__('Quotation Responded Successfully.'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    // Order Cancel
    public function cancelOrder(OrderRequest $request)
    {
        try {
            $this->orderRepository->orderCancel($request);
            return responseBuilder()->success(__('Order Cancelled Successfully.'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    // Order In Progress
    public function inProgress(OrderRequest $request)
    {
        try {
            $this->orderRepository->inProgress($request);
            return responseBuilder()->success(__('Order is In Progress Successfully.'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    // Order Complete
    public function complete(OrderRequest $request)
    {
        try {
            $this->orderRepository->complete($request);
            return responseBuilder()->success(__('Order is Completed Successfully.'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function printInvoice($id)
    {
        DB::beginTransaction();
        try {
            $invoiceUrl = $this->orderRepository->generatePDF($id);
            DB::commit();
            return response([
                'success' => true,
                'data' => $invoiceUrl
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'success' => false,
                'data' => $e->getMessage()
            ]);
        }
    }

    public function sendInvoice($id)
    {
        try {
            $this->orderRepository->sendInvoice($id);
            return response([
                'success' => true,
                'message' => __('Invoice sent to the registered email')
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
