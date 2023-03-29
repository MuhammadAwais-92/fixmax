<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;

use Exception;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\OrderRepository;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use App\Traits\MyTechnologyPayPal;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Common\PayPalModel;

class CheckoutRepository extends Repository
{
    use MyTechnologyPayPal;
    protected $cartRepository, $serviceRepository, $orderRepository, $orderItemsRepository, $orderTransactionRepository,$couponRepository;
    public function __construct(CartRepository $cartRepository, ServiceRepository $serviceRepository,CouponRepository $couponRepository, OrderRepository $orderRepository, OrderItemsRepository $orderItemsRepository, OrderTransactionRepository $orderTransactionRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->serviceRepository = $serviceRepository;
        $this->orderRepository = $orderRepository;
        $this->orderItemsRepository = $orderItemsRepository;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->couponRepository = $couponRepository;
    }
    public function save($request)
    {

        DB::beginTransaction();
        try {
            if ($request->checkout == 'first') {
                $user = $this->getUser();
                $this->cartRepository->setFromWeb($this->getFromWeb());
                $this->serviceRepository->setFromWeb($this->getFromWeb());
                $this->cartRepository->setRelations([
                    'service',
                    'service.images',
                    'equipments',
                    'equipments.equipment'

                ]);
                $this->initPayPal();
                if ($request->payment_method == 'paypal') {
                    $payerId = $request->payerID;
                    $paymentID = $request->paymentID;
                    $payment = Payment::get($paymentID, $this->apiContext);
                    $execution = new PaymentExecution();
                    $execution->setPayerId($payerId);
                    $result = $payment->execute($execution, $this->apiContext);
                    if ($result->getState() == 'approved') {
                        $order = $this->placeOrder($request);
                        $paymentData = $payment->toArray();
                        $orderTransaction = $this->orderTransactionRepository->save($payment, $order);
                        $order->first_name =  (isset($paymentData['payer']['payer_info']['first_name'])) ? $paymentData['payer']['payer_info']['first_name'] : '';
                        $order->last_name = (isset($paymentData['payer']['payer_info']['last_name'])) ? $paymentData['payer']['payer_info']['last_name'] : '';
                        $order->save();
                        $userId = ['user_id' => $user->id];
                        $this->cartRepository->delete($userId, $order->service_id);
                        sendNotification([ // send to user
                            'sender_id' => $user->id,
                            'receiver_id' => $user->id,
                            'extras->quotation_id' => $order->id,
                            'extras->service_id' => $order->service_id,
                            'extras->service_name' => $order->service_name,
                            'extras->image' => $order->service_image,
                            'title->en' => 'Quotation Request Has Been placed',
                            'title->ar' => 'تم تقديم طلب عرض الأسعار',
                            'title->ru' => 'Запрос котировок был размещен',
                            'title->ur' => 'کوٹیشن کی درخواست دی گئی ہے۔',
                            'title->hi' => 'कोटेशन अनुरोध रखा गया है',
                            'description->en' => '<p class="p-text">Quotation (<span>#'.$order->order_number.'</span>) has been created. Please visit the quotation details page for further details</p>',
                            'description->ar' => '<p class="p-text">تم إنشاء الاقتباس.(<span>#'.$order->order_number.'</span>) يرجى زيارة صفحة تفاصيل الاقتباس لمزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                            'description->hi' => '<p class="p-text">कोटेशन (<span>#'.$order->order_number.'</span>) बनाया गया है। अधिक जानकारी के लिए कृपया उद्धरण विवरण पृष्ठ पर जाएं</p>',
                            'description->ur' => '<p class="p-text">کوٹیشن (<span>#'.$order->order_number.'</span>) بنا دیا گیا ہے۔ مزید تفصیلات کے لیے براہ کرم کوٹیشن کی تفصیلات کا صفحہ دیکھیں</p>',
                            'description->ru' => '<p class="p-text">Предложение (<span>#'.$order->order_number.'</span>) создано. Пожалуйста, посетите страницу деталей предложения для получения дополнительной информации</p>',
                            'action' => 'QUOTATION'
                        ]);

                        sendNotification([ // send to supplier
                            'sender_id' => $user->id,
                            'receiver_id' => $order->supplier_id,
                            'extras->quotation_id' => $order->id,
                            'extras->service_id' => $order->service_id,
                            'extras->service_name' => $order->service_name,
                            'extras->image' => $order->service_image,
                            'title->en' => 'New Quotation Request Has Been Received',
                            'title->ar' => 'تم استلام طلب عرض أسعار جديد',
                            'title->ru' => 'Получен новый запрос котировок',
                            'title->hi' => 'नया कोटेशन अनुरोध प्राप्त हुआ है',
                            'title->ur' => 'نئی کوٹیشن کی درخواست موصول ہوئی ہے۔',
                            'description->en' => '<p class="p-text">You have received a new quotation request (<span>#'.$order->order_number.'</span> ).Please visit the quotation details page for further details</p>',
                            'description->ar' => '<p class="p-text">لقد تلقيت طلب عرض أسعار جديدًا(<span>#'.$order->order_number.'</span> ). الرجاء زيارة صفحة تفاصيل عرض الأسعار لمزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                            'description->ru' => '<p class="p-text">Вы получили новый запрос предложения (<span>#'.$order->order_number.'</span>). Пожалуйста, посетите страницу сведений о предложении для получения дополнительной информации.</p>',
                            'description->ur' => '<p class="p-text">آپ کو کوٹیشن کی ایک نئی درخواست موصول ہوئی ہے (<span>#'.$order->order_number.'</span>) .مزید تفصیلات کے لیے براہ کرم کوٹیشن کی تفصیلات کا صفحہ دیکھیں۔</p>',
                            'description->hi' => '<p class="p-text">आपको एक नया उद्धरण अनुरोध प्राप्त हुआ है (<span>#'.$order->order_number.'</span> )। कृपया अधिक विवरण के लिए उद्धरण विवरण पृष्ठ पर जाएं</p>',
                            'action' => 'QUOTATION'
                        ]);
                    } else {
                        set_alert('danger', __('Payment failed! Your order is canceled.'));
                        return false;
                    }
                }
            } else {
                $user = $this->getUser();
                $this->orderRepository->setFromWeb($this->getFromWeb());


                $this->initPayPal();
                if ($request->payment_method == 'paypal') {
                    $payerId = $request->payerID;
                    $paymentID = $request->paymentID;
                    $payment = Payment::get($paymentID, $this->apiContext);
                    $execution = new PaymentExecution();
                    $execution->setPayerId($payerId);
                    $result = $payment->execute($execution, $this->apiContext);
                    if ($result->getState() == 'approved') {
                        $order = $this->placeFinalOrder($request);

                        $paymentData = $payment->toArray();
                        $orderTransaction = $this->orderTransactionRepository->save($payment, $order);
                        $order->first_name =  (isset($paymentData['payer']['payer_info']['first_name'])) ? $paymentData['payer']['payer_info']['first_name'] : '';
                        $order->last_name = (isset($paymentData['payer']['payer_info']['last_name'])) ? $paymentData['payer']['payer_info']['last_name'] : '';
                        $order->save();
                        sendNotification([ // send to user
                            'sender_id' => $user->id,
                            'receiver_id' => $user->id,
                            'extras->order_id' => $order->id,
                            'extras->service_id' => $order->service_id,
                            'extras->service_name' => $order->service_name,
                            'extras->image' => $order->service_image,
                            'title->en' => 'Quotation Accepted and Order Created',
                            'title->ar' => 'تم قبول عرض الأسعار وإنشاء الطلب',
                            'title->ru' => 'Предложение принято и заказ создан',
                            'title->ur' => 'کوٹیشن کو قبول کر لیا گیا اور آرڈر بنایا گیا۔',
                            'title->hi' => 'कोटेशन स्वीकृत और आदेश बनाया गया',
                            'description->en' => '<p class="p-text">Order has been placed on Quotation(<span>#'.$order->order_number.'</span> ).Please visit the order details page for further details</p>',
                            'description->ar' => '<p class="p-text">تم تقديم الطلب في عرض الأسعار (<span>#'.$order->order_number.'</span> ). الرجاء زيارة صفحة تفاصيل الطلب للحصول على مزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                            'description->ru' => '<p class="p-text">Заказ был размещен по предложению (<span>#'.$order->order_number.'</span>). Пожалуйста, посетите страницу сведений о заказе для получения дополнительной информации</p>',
                            'description->ur' => '<p class="p-text">آرڈر کوٹیشن (<span>#'.$order->order_number.'</span>) پر دیا گیا ہے۔ مزید تفصیلات کے لیے براہ کرم آرڈر کی تفصیلات کا صفحہ دیکھیں۔</p>',
                            'description->hi' => '<p class="p-text">ऑर्डर कोटेशन (<span>#'.$order->order_number.'</span> ) पर दिया गया है। कृपया अधिक जानकारी के लिए ऑर्डर विवरण पृष्ठ पर जाएं</p>',
                            'action' => 'ORDER'
                        ]);
                        sendNotification([ // send to user
                            'sender_id' => $user->id,
                            'receiver_id' => $order->supplier_id,
                            'extras->order_id' => $order->id,
                            'extras->service_id' => $order->service_id,
                            'extras->service_name' => $order->service_name,
                            'extras->image' => $order->service_image,
                            'title->en' => 'Quotation Accepted and Order Created.',
                            'title->ar' => 'تم قبول عرض الأسعار وإنشاء الطلب.',
                            'title->ru' => 'Предложение принято и заказ создан.',
                            'title->ur' => 'کوٹیشن کو قبول کر لیا گیا اور آرڈر بنایا گیا۔',
                            'title->hi' => 'कोटेशन स्वीकृत और आदेश बनाया गया।',
                            'description->en' => '<p class="p-text">You have received and order on Quotation (<span>#'.$order->order_number.'</span>).Please visit the order details page for further details</p>',
                            'description->ar' => '<p class="p-text">لقد تلقيت وطلبت على عرض الأسعار (<span>#'.$order->order_number.'</span>). الرجاء زيارة صفحة تفاصيل الطلب للحصول على مزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                            'description->ru' => '<p class="p-text">Вы получили и заказали по предложению (<span>#'.$order->order_number.'</span>). Пожалуйста, посетите страницу сведений о заказе для получения дополнительной информации</p>',
                            'description->ur' => '<p class="p-text">آپ کو کوٹیشن (<span>#'.$order->order_number.'</span>) موصول ہوا ہے اور آرڈر کیا گیا ہے۔ مزید تفصیلات کے لیے براہ کرم آرڈر کی تفصیلات کا صفحہ دیکھیں۔</p>',
                            'description->hi' => '<p class="p-text">आपने कोटेशन (<span>#'.$order->order_number.'</span>) पर प्राप्त कर लिया है और ऑर्डर कर दिया है। कृपया अधिक विवरण के लिए ऑर्डर विवरण पृष्ठ पर जाएं।</p>', 
                            'action' => 'ORDER'
                        ]);
                    } else {
                        set_alert('danger', __('Payment failed! Your order is canceled.'));
                        return false;
                    }
                }
            }


            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function placeOrder($request)
    {
        $user = $this->getUser();
        $this->orderRepository->setFromWeb($this->getFromWeb());
        $cartData = $this->cartRepository->getCheckoutContent($request->service_id);
        $orderNumber = Str::random(6);
        $order = $this->orderRepository->save($request, $orderNumber, $cartData);
        $total = 0;
        if ($cartData->equipments->isNotEmpty()) {
            foreach ($cartData->equipments as $equipment) {
                $eq = Equipment::find($equipment['equipment_id']);
                $equipment->name = $eq->name;
                $equipment->equipment_model = $eq->equipment_model;
                $equipment->make = $eq->make;
                $equipment->image = $eq->image_url;
                $equipment->qty_1 = $equipment->quantity;
                $equipment->total_1 = $equipment->quantity*$equipment->price;
                $equipment->qty_2 = '0';
                $equipment->total_2 = '0.00';
                $orderItem = $this->orderItemsRepository->save($equipment, $order);
                $total = $total + $orderItem->total;
            }
        }
        if ($order->issue_type == 'know') {
            $order->subtotal = $total;
            $order->amount_paid =  $order->subtotal + $order->vat_1 + $order->visit_fee;
            $order->total_amount = $order->subtotal + $order->vat_1 + $order->visit_fee;
        } else {
            $order->subtotal = $order->visit_fee;
            $order->amount_paid =  $order->subtotal + $order->vat_1;
            $order->total_amount = $order->subtotal + $order->vat_1;
        }
        $order->save();
        return $order;
    }
    public function placeFinalOrder($request)
    {
        $this->orderRepository->setRelations([
            'service',
            'service.supplier',
            'user',
            'user.addresses',
            'orderItems'
        ]);
        $user = $this->getUser();
        $orderData = $this->orderRepository->getCheckoutContent($request->order_id);
        $order = $this->orderRepository->get($request->order_id);
        $order->vat_2 = $orderData->vat;
        $order->vat_percentage_2 = $orderData->vatPercentage;
        $order->subtotal = $order->orderItems->isNotEmpty() ? $order->subtotal : '0';
        $order->subtotal = $order->subtotal + ($orderData->amount_paid - $orderData->visit_fee - $orderData->vat_1);
        $orderData->subtotal = $order->orderItems->isNotEmpty() ? $orderData->subtotal : '0';
        $order->total_amount = $orderData->amount_paid + $orderData->vat + $orderData->subtotal + $orderData->quoated_price;
        $order->status = 'confirmed';
        $order->subtotal= $order->total_amount-$order->vat_1-$order->vat_2 -$orderData->quoated_price-$order->visit_fee;
        $coupon_check     = false;
        if (isset($user->coupon) && !empty($user->coupon)) {
            $coupon_discount = $this->couponRepository->isValid($user);

            if (!empty($coupon_discount)) {

                $coupon_check     = true;
                $order->discount  = $orderData->discount;
                $order->total_amount= $order->total_amount- $order->discount;
            }
        }
        $order->save();
        if ($coupon_check) {
            $this->couponRepository->setFromWeb($this->getFromWeb());
            $this->couponRepository->destroy(null, true);
        }

        return $order;
    }
    public function get($userId, $serviceId)
    {
        $query = $this->getModel()->query();
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }
        if (!is_null($serviceId)) {
            $query->where('service_id', $serviceId);
        }
        $cart = $query->select($this->getSelect())->with($this->getRelations())->first();
        return $cart;
    }
    public function getCheckoutContent($serviceId)
    {
        $user = $this->getUser();
        $cart = $this->get($user->id, $serviceId);
        if ($cart->issue_type == 'know') {
            $cart->subTotal = $cart->total + $cart->visit_fee;
            $cart->visit_fee = $cart->visit_fee;
            $cart->date = date('m/d/Y', $cart->date);
            $cart->vatPercentage = config('settings.value_added_tax');
            $cart->vat = $cart->subTotal * (config('settings.value_added_tax') / 100);
            $cart->total = $cart->subTotal + $cart->vat;
        } else {
            $cart->subTotal = $cart->total;
            $cart->date = date('m/d/Y', $cart->date);
            $cart->vatPercentage = config('settings.value_added_tax');
            $cart->vat = $cart->subTotal * (config('settings.value_added_tax') / 100);
            $cart->total = $cart->subTotal + $cart->vat;
        }
        return $cart;
    }
}
