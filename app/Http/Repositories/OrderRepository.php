<?php


namespace App\Http\Repositories;

use App\Http\Dtos\ReviewSaveDto;
use Illuminate\Support\Facades\File;

use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Dtos\SendEmailDto;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use App\Jobs\SendMail;
use App\Models\Review;
use Carbon\Carbon;
use App\Traits\MyTechnologyPayPal;
use Illuminate\Support\Str;

use function request;


class OrderRepository extends Repository
{
    use MyTechnologyPayPal;
    protected $addressRepository, $orderItemsRepository, $userRepository,$couponRepository;
    public function __construct(UserRepository $userRepository,CouponRepository $couponRepository,AddressRepository $addressRepository, OrderItemsRepository $orderItemsRepository)
    {
        $this->setModel(new Order());
        $this->orderItemsRepository = $orderItemsRepository;
        $this->addressRepository = $addressRepository;
        $this->userRepository = $userRepository;
        $this->couponRepository = $couponRepository;

    }

    public function all($status = 'all', $user_id = 0, $supplier_id = 0)
    {
        $query = $this->getQuery();
        if ($status != 'all') {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['pending', 'visited', 'rejected', 'confirmed', 'quoted']);
        }
        if ($user_id > 0) {
            $query->where('user_id', $user_id);
        }
        if ($supplier_id > 0) {
            // $query->whereHas('service', function ($q) use ($supplier_id) {
            //     $q->where('user_id', $supplier_id);
            // });
            $query->where('supplier_id', $supplier_id);
        }
        if ($this->getPaginate() > 0) {
            $quotations = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $quotations = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $quotations;
    }
    public function ordersall($status = 'all', $user_id = 0, $supplier_id = 0)
    {

        $query = $this->getQuery();
        if ($status != 'all') {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['confirmed', 'in-progress', 'completed', 'cancelled']);
        }
        if ($user_id > 0) {
            $query->where('user_id', $user_id);
        }
        if ($supplier_id > 0) {
            // $query->whereHas('service', function ($q) use ($supplier_id) {
            //     $q->where('user_id', $supplier_id);
            // });
            $query->where('supplier_id', $supplier_id);
        }
        if ($this->getPaginate() > 0) {
            $quotations = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $quotations = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $quotations;
    }
    public function get($id = 0, $user_id = 0, $supplier_id = 0)
    {
        $query = $this->getQuery();
        if ($id > 0) {
            $query->where('id', $id);
        }
        if ($user_id > 0) {
            $query->where('user_id', $user_id);
        }
        if ($supplier_id > 0) {
            $query->where('supplier_id', $supplier_id);
            // $query->whereHas('service', function ($q) use ($supplier_id) {
            //     $q->where('user_id', $supplier_id);
            // });
        }
        $quotation = $query->select($this->getSelect())->with($this->getRelations())->first();

        return $quotation;
    }
    public function allAdminQuotations()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'service_id', 'dt' => 'service_id'],
            ['db' => 'supplier_id', 'dt' => 'supplier_id'],
            ['db' => 'order_number', 'dt' => 'order_number'],
            ['db' => 'service_name', 'dt' => 'service_name'],
            ['db' => 'status', 'dt' => 'status'],
            ['db' => 'total_amount', 'dt' => 'total_amount'],


        ];
        DataTable::init(new Order(), $columns);
        $order_number = request('datatable.query.order_number', '');
        $date_from = request('datatable.query.date_from', '');
        $date_to = request('datatable.query.date_to', '');
        $user_name = request('datatable.query.user_name', '');
        $supplier_name = request('datatable.query.supplier_name', '');
        $payment_method = request('datatable.query.payment_method', '');
        $status = request('datatable.query.status', '');
        $min = request('datatable.query.min', '');
        $max = request('datatable.query.max', '');
        if (!empty($order_number)) {
            DataTable::where('order_number', '=', $order_number);
        }
        if (!empty($min)) {
            DataTable::where('amount_paid', '>=', $min);
        }
        if (!empty($max)) {
            DataTable::where('amount_paid', '<=', $max);
        }
        if ($status != "") {

            DataTable::where('status', '=', $status);
        }
        // $min = request('datatable.query.min', '');
        // $max = request('datatable.query.max', '');
        // if (!empty($title)) {
        //     DataTable::whereJsonContains('name->en', $title);
        // }
        if (!empty($min)) {
            DataTable::where('total_amount', '>=', $min);
        }
        if (!empty($max)) {
            DataTable::where('total_amount', '<=', $max);
        }
        // if (!empty($category)) {


        DataTable::whereIn('status', ['pending', 'visited', 'rejected', 'confirmed', 'quoted']);
        DataTable::with('supplier');
        DataTable::with('service');
        DataTable::with('user');
        if (!empty($supplier_name)) {
            DataTable::whereHas('supplier', function ($query) use ($supplier_name) {
                return $query->whereJsonContains('supplier_name->en', $supplier_name);
            });
        }

        //     // DataTable::whereJsonContains('name->en',$category);
        // }

        $quotations = DataTable::get();

        $start = 1;
        if ($quotations['meta']['start'] > 0 && $quotations['meta']['page'] > 1) {
            $start = $quotations['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($quotations['data']) > 0) {
            foreach ($quotations['data'] as $key => $data) {

                $quotations['data'][$key]['id'] = $count++;
                $quotations['data'][$key]['order_number'] = $data['order_number'];
                $quotations['data'][$key]['user_name']  = $quotations['data'][$key]['user']['user_name'];
                $quotations['data'][$key]['service_name']  = $data['service_name']['en'];
                $quotations['data'][$key]['total_amount'] = $data['total_amount'];
                $quotations['data'][$key]['supplier_name']  = $quotations['data'][$key]['supplier']['supplier_name']['en'];
                $quotations['data'][$key]['status']  = $data['status'] == 'confirmed' ? 'Accepted' : ($data['status'] == 'rejected' ? 'Cancelled' : ucfirst($data['status']));
                // if ($data['status'] == 'pending')
                //     $quotations['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.quotation.detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill title="View"> <i class="fa fa-eye"></i></a>' .
                //         '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill deactivate-record-button href="javascript:{};" data-url="' . route('admin.dashboard.quotation.cancel', $data['id'])  . '" title="Cancel"><i class="fa fa-times"></i></a>';
                // else
                    $quotations['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.quotation.detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill title="View"> <i class="fa fa-eye"></i></a>';
            }
        }

        return $quotations;
    }
    public function allAdminOrders()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'service_id', 'dt' => 'service_id'],
            ['db' => 'supplier_id', 'dt' => 'supplier_id'],
            ['db' => 'order_number', 'dt' => 'order_number'],
            ['db' => 'service_name', 'dt' => 'service_name'],
            ['db' => 'status', 'dt' => 'status'],
            ['db' => 'total_amount', 'dt' => 'total_amount'],
            ['db' => 'platform_commission', 'dt' => 'platform_commission'],



        ];
        DataTable::init(new Order(), $columns);
        $order_number = request('datatable.query.order_number', '');
        $date_from = request('datatable.query.date_from', '');
        $date_to = request('datatable.query.date_to', '');
        $user_name = request('datatable.query.user_name', '');
        $supplier_name = request('datatable.query.supplier_name', '');
        $payment_method = request('datatable.query.payment_method', '');
        $status = request('datatable.query.status', '');
        $min = request('datatable.query.min', '');
        $max = request('datatable.query.max', '');
        if (!empty($order_number)) {
            DataTable::where('order_number', '=', $order_number);
        }
        if (!empty($min)) {
            DataTable::where('total_amount', '>=', $min);
        }
        if (!empty($max)) {
            DataTable::where('total_amount', '<=', $max);
        }
        if ($status != "") {

            DataTable::where('status', '=', $status);
        }
        // $min = request('datatable.query.min', '');
        // $max = request('datatable.query.max', '');
        // if (!empty($title)) {
        //     DataTable::whereJsonContains('name->en', $title);
        // }
        // if (!empty($min)) {
        //     DataTable::where('price', '>', $min);
        // }
        // if (!empty($max)) {
        //     DataTable::where('price', '<', $max);
        // }
        // if (!empty($category)) {


        DataTable::whereIn('status', ['completed', 'cancelled', 'in-progress', 'confirmed']);
        DataTable::with('supplier');
        DataTable::with('service');
        DataTable::with('user');
        //     DataTable::whereHas('categories', function ($query) use ($category) {
        //         return $query->where('category_id', $category);
        //     });
        //     // DataTable::whereJsonContains('name->en',$category);
        // }

        $quotations = DataTable::get();

        $start = 1;
        if ($quotations['meta']['start'] > 0 && $quotations['meta']['page'] > 1) {
            $start = $quotations['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($quotations['data']) > 0) {
            foreach ($quotations['data'] as $key => $data) {

                $quotations['data'][$key]['id'] = $count++;
                $quotations['data'][$key]['order_number'] = $data['order_number'];
                $quotations['data'][$key]['user_name']  = $quotations['data'][$key]['user']['user_name'];
                $quotations['data'][$key]['service_name']  = $data['service_name']['en'];
                $quotations['data'][$key]['total_amount'] = $data['total_amount'];
                $quotations['data'][$key]['platform_commission'] = $data['platform_commission'] ? $data['platform_commission'] : '0';
                $quotations['data'][$key]['supplier_name']  = $quotations['data'][$key]['supplier']['supplier_name']['en'];
                $quotations['data'][$key]['status']  = $data['status'] == 'confirmed' ? 'Pending' : ucfirst($data['status']);
                // if ($data['status'] == 'confirmed')
                //     $quotations['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.order.detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill title="View"> <i class="fa fa-eye"></i></a>' .
                //         '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill deactivate-record-button href="javascript:{};" data-url="' . route('admin.dashboard.order.cancel', $data['id'])  . '" title="Cancel"><i class="fa fa-times"></i></a>';
                // else {
                    $quotations['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.order.detail', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill title="View"> <i class="fa fa-eye"></i></a>';
                // }
            }
        }

        return $quotations;
    }
    public function save($request = null, $orderNumber = null, $cartData = null)
    {

        $this->setFromWeb($this->getFromWeb());
        $user = $this->getUser();
        $address = $this->addressRepository->getModel()->where([['id', $request->get('selected_address')], ['user_id', $user->id]])->first();

        $status = "pending";
        return $this->getQuery()->create([
            'user_id' => $user->id,
            'service_id' => $cartData->service_id,
            'supplier_id' => $cartData->supplier_id,
            'full_name' => $user->user_name,
            'first_name' => "",
            'last_name' => "",
            'address' => $address,
            'order_number' => $orderNumber,
            'status' => $status,
            'service_name' => $cartData->service->name,
            'min_price' => $cartData->service->service_type == 'offer' ? $cartData->service->getFormattedModel()->discountedMinPrice :  $cartData->service->getFormattedModel()->min_price,
            'max_price' => $cartData->service->service_type == 'offer' ? $cartData->service->getFormattedModel()->dicountedMaxPrice :  $cartData->service->getFormattedModel()->max_price,
            'order_notes' => $request->order_notes,
            'issue_images' => $cartData->issue_images,
            'image' => $cartData->service->order_image,
            'visit_fee' => $cartData->visit_fee,
            'date' => $this->getFromWeb() ?  DateToUnixformat($cartData->date) : $cartData->date,
            'time' => $cartData->time,
            'issue_type' => $cartData->issue_type,
            'vat_1' =>  $cartData->vat,
            'vat_percentage_1' => $cartData->vatPercentage,
        ]);
    }
    public function getQuotationSummary($quotationId)
    {
        if ($this->getFromAdmin()) {
            $quotation = $this->get($quotationId);
        } else {
            $user = $this->getUser();
            if ($user->isUser()) {
                $quotation = $this->get($quotationId, $user->id);
            } else {
                $quotation = $this->get($quotationId);
            }
        }

        if ($quotation->status == "confirmed") {
            $quotation->subtotal = $quotation->total_amount - $quotation->amount_paid - $quotation->quoated_price - $quotation->vat_2;
        }
        return $quotation;
    }
    public function getCheckoutContent($quotationId)
    {
        $user = $this->getUser();
        $quotation = $this->get($quotationId);
        $quotation->subTotal = $quotation->quoated_price;
        $quotation->vatPercentage = config('settings.value_added_tax');
        $quotation->discountPercentage   = 0;
        $quotation->couponUsed       = false;
        $quotation->removeCoupon     = false;
        $quotation->discount             = 0;
        if (isset($user->coupon) && !empty($user->coupon)) {
            $coupon_discount = $this->couponRepository->isValid($user);
            $quotation->couponUsed = true;
            if ($coupon_discount) {
                $quotation->discountPercentage = $coupon_discount;
            } else {
                $quotation->removeCoupon = true;
                $quotation->discountPercentage = 0;
            }
        }
        if ($quotation->orderItems->isNotEmpty()) {
            $quotation->subtotal = ($quotation->orderItems->sum('total')) - ($quotation->amount_paid - $quotation->visit_fee - $quotation->vat_1);


            $quotation->equipment_charges = $quotation->subtotal;
            $quotation->vat = ($quotation->quoated_price + $quotation->subtotal) * (config('settings.value_added_tax') / 100);
            if ($quotation->couponUsed && !$quotation->removeCoupon) {
                $discountedAmount   = ($quotation->quoated_price+$quotation->equipment_charges) * ($quotation->discountPercentage / 100);
                $quotation->discount = $discountedAmount;
                $quotation->vat=($quotation->quoated_price+$quotation->equipment_charges-$discountedAmount) * (config('settings.value_added_tax') / 100);
                $quotation->grandtotal = $quotation->quoated_price + $quotation->equipment_charges + $quotation->vat-$quotation->discount;
            } else {
                $quotation->grandtotal = $quotation->quoated_price + $quotation->equipment_charges + $quotation->vat;

            }
        } else {
            $quotation->vat = ($quotation->quoated_price) * (config('settings.value_added_tax') / 100);
            if ($quotation->couponUsed && !$quotation->removeCoupon) {
                $discountedAmount   = $quotation->quoated_price * ($quotation->discountPercentage / 100);
                $quotation->discount = $discountedAmount;
                $quotation->vat=($quotation->quoated_price-$discountedAmount) * (config('settings.value_added_tax') / 100);
                $quotation->grandtotal = $quotation->quoated_price  + $quotation->vat-$quotation->discount;
            } else {
                $quotation->grandtotal = $quotation->quoated_price  + $quotation->vat;
            }
        }
        $quotation->date = date('m/d/Y', $quotation->date);
        return $quotation;
    }
    public function visit($request)
    {
        DB::beginTransaction();
        try {
            $quotation = $this->getModel()->where(['id' => $request->id])->first();
            $updateQuotation = [];
            $update = true;
            if ($quotation->status == 'rejected' || $quotation->status == 'quoted' || $quotation->status == 'confirmed' || $quotation->status == 'completed' || $quotation->status == 'cancelled') {
                $update = false;
            }
            if ($update) {
                $updateQuotation = ['status' => $request->status];
            }
            $quotation->update($updateQuotation);
            $user = $this->getUser();
            sendNotification([ // send to user
                'sender_id' => $user->id,
                'receiver_id' => $quotation->user_id,
                'extras->quotation_id' => $quotation->id,
                'extras->service_id' => $quotation->service_id,
                'extras->service_name' => $quotation->service_name,
                'extras->image' => $quotation->service_image,
                'title->en' => 'Supplier has visited on Quotation Request.',
                'title->ar' => 'زار المورد في طلب عرض الأسعار.',
                'title->ru' => 'Поставщик посетил запрос котировок.',
                'title->hi' => 'आपूर्तिकर्ता ने कोटेशन अनुरोध पर दौरा किया है।',
                'title->ur' => 'سپلائر نے کوٹیشن کی درخواست پر دورہ کیا ہے۔',
                'description->en' => '<p class="p-text">Supplier has visited against your Quotation Request(<span>#'.$quotation->order_number.'</span>).Please visit the quotation detail page for further details</p>',
                'description->ar' => '<p class="p-text">قام المورد بالزيارة بناءً على طلب عرض الأسعار الخاص بك (<span>#'.$quotation->order_number.'</span>). يرجى زيارة صفحة تفاصيل عرض الأسعار للحصول على مزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                'description->ru' => '<p class="p-text">Поставщик посетил ваш запрос предложения (<span>#'.$quotation->order_number.'</span>). Пожалуйста, посетите страницу сведений о предложении для получения дополнительной информации</p>',
                'description->hi' => '<p class="p-text">आपूर्तिकर्ता ने आपके कोटेशन अनुरोध (<span>#'.$quotation->order_number.'</span>) पर विज़िट किया है। कृपया अधिक विवरण के लिए उद्धरण विवरण पृष्ठ पर जाएं।</p>',
                'description->ur' => '<p class="p-text">فراہم کنندہ نے آپ کی کوٹیشن کی درخواست (<span>#'.$quotation->order_number.'</span>) کا دورہ کیا ہے۔ مزید تفصیلات کے لیے براہ کرم کوٹیشن کی تفصیل کا صفحہ دیکھیں۔</p>',
                'action' => 'QUOTATION'
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function inProgress($request)
    {
        DB::beginTransaction();
        try {
            $quotation = $this->getModel()->where(['id' => $request->id])->first();
            $updateQuotation = [];
            $update = true;
            if ($quotation->status == 'completed') {
                $update = false;
            }
            if ($update) {
                $updateQuotation = ['status' => $request->status];
            }
            $quotation->update($updateQuotation);
            $user = $this->getUser();
            sendNotification([ // send to user
                'sender_id' => $user->id,
                'receiver_id' => $quotation->user_id,
                'extras->order_id' => $quotation->id,
                'extras->service_id' => $quotation->service_id,
                'extras->service_name' => $quotation->service_name,
                'extras->image' => $quotation->service_image,
                'title->en' => 'Order is In Progress.',
                'title->ar' => 'الطلب قيد التقدم.',
                'title->ru' => 'Заказ находится в процессе.',
                'title->ur' => 'آرڈر جاری ہے۔',
                'title->hi' => 'आदेश प्रगति पर है।',
                'description->en' => '<p class="p-text">Your Order (<span>#'.$quotation->order_number.'</span>) is in progress.Please visit the order detail page for further details</p>',
                'description->ar' => '<p class="p-text">طلبك (<span>#'.$quotation->order_number.'</span>) قيد التقدم. الرجاء زيارة صفحة تفاصيل الطلب للحصول على مزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                'description->ru' => '<p class="p-text">Ваш заказ (<span>#'.$quotation->order_number.'</span>) находится в обработке. Для получения дополнительной информации посетите страницу сведений о заказе.</p>',
                'description->ur' => '<p class="p-text">آپ کا آرڈر (<span>#'.$quotation->order_number.'</span>) جاری ہے۔ مزید تفصیلات کے لیے براہ کرم آرڈر کی تفصیل کا صفحہ دیکھیں</p>',
                'description->hi' => '<p class="p-text">आपका आदेश (<span>#'.$quotation->order_number.'</span>) प्रगति पर है। कृपया अधिक विवरण के लिए आदेश विवरण पृष्ठ पर जाएं</p>',
                'action' => 'ORDER'
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function complete($request)
    {
        DB::beginTransaction();
        try {
            $quotation = $this->getModel()->where(['id' => $request->id])->first();
            $updateQuotation = [];
            $update = true;
            if (!$quotation->status == 'in-progress') {
                $update = false;
            }
            if ($update) {
                $updateQuotation = ['status' => $request->status];
                $comPercentage = config('settings.platform_commision_percentage');
                $fromCommission=$quotation->total_amount-$quotation->vat_1 - $quotation->vat_2;

                $amountPercentage = ($comPercentage / 100) * $fromCommission;
                $platformComission = config('settings.platform_commision');
                if ($amountPercentage > $platformComission) {
                    $updateQuotation['platform_commission'] = $amountPercentage;
                } else {
                    $updateQuotation['platform_commission']  = $platformComission;
                }
            }
            $quotation->update($updateQuotation);
            $userArray = [];
            $orderUser = $this->userRepository->get($quotation->supplier_id);
            $available_balance = $quotation->total_amount - $quotation->vat_1 - $quotation->vat_2 - $quotation->platform_commission;
            $totalAvailableBalance = $orderUser->available_balance + $available_balance;
            $totalCommission= $orderUser->total_commission;
            $userArray = ['available_balance' => $totalAvailableBalance];
            $userArray['total_commission'] =  $quotation->platform_commission + $totalCommission;
            $userArray['total_earning'] =  $orderUser->total_earning + $quotation->total_amount;
            $orderUser->update($userArray);
            $user = $this->getUser();
            sendNotification([ // send to user
                'sender_id' => $user->id,
                'receiver_id' => $quotation->user_id,
                'extras->order_id' => $quotation->id,
                'extras->service_id' => $quotation->service_id,
                'extras->service_name' => $quotation->service_name,
                'extras->image' => $quotation->service_image,
                'title->en' => 'Your Order Has Been Completed.',
                'title->ar' => 'تم إكمال طلبك.',
                'title->ru' => 'Ваш заказ выполнен.',
                'title->ur' => 'آپ کا آرڈر مکمل ہو گیا ہے۔',
                'title->hi' => 'आपका आदेश पूरा हो गया है।',
                'description->en' => '<p class="p-text">Your Order#(<span>'.$quotation->order_number.'</span>) has been completed.Please visit the order detail page for further details</p>',
                'description->ar' => '<p class="p-text">تم إكمال طلبك رقم (<span>'.$quotation->order_number.'</span>). الرجاء زيارة صفحة تفاصيل الطلب للحصول على مزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                'description->ru' => '<p class="p-text">Ваш заказ № (<span>'.$quotation->order_number.'</span>) выполнен. Для получения дополнительной информации посетите страницу сведений о заказе.</p>',
                'description->ur' => '<p class="p-text">آپ کا آرڈر#(<span>'.$quotation->order_number.'</span>) مکمل ہو گیا ہے۔ مزید تفصیلات کے لیے براہ کرم آرڈر کی تفصیل کا صفحہ دیکھیں</p>',
                'description->hi' => '<p class="p-text">आपका आदेश#(<span>'.$quotation->order_number.'</span>) पूरा हो गया है। कृपया अधिक विवरण के लिए आदेश विवरण पृष्ठ पर जाएं</p>',               
                'action' => 'ORDER'
            ]);

            $reviewRepository = new ReviewRepository();
            $reviewCollection = collect([
                'id' => 0,
                'user_id' => $quotation->user_id,
                'supplier_id' => $user->id,
                'order_id' => $quotation->id,
                'service_id' => 0,
                'rating' => 0.0,
                'review' => null,
                'is_reviewed' => false,
            ]);
            $reviewSaveDto = ReviewSaveDto::fromCollection($reviewCollection);
            $reviewRepository->save($reviewSaveDto);
            sendNotification([ // send to user
                'sender_id' => $user->id,
                'receiver_id' => $quotation->user_id,
                'extras->order_id' => $quotation->id,
                'extras->service_id' => $quotation->service_id,
                'extras->supplier_id' => $quotation->supplier_id,
                'extras->service_name' => $quotation->service_name,
                'extras->image' => $quotation->service_image,
                'title->en' => 'Rate and review the Supplier.',
                'title->ar' => 'تقييم ومراجعة المورد.',
                'title->ru' => 'Оцените и просмотрите Поставщика.',
                'title->ur' => 'فراہم کنندہ کی درجہ بندی اور جائزہ لیں۔',
                'title->hi' => 'आपूर्तिकर्ता को रेट करें और उसकी समीक्षा करें।',
                'description->en' => '<p class="p-text">Your Order#(<span>'.$quotation->order_number.'</span>) has been completed. Kindly spare a moment and leave a review for the supplier</p>',
                'description->ar' => '<p class="p-text">تم إكمال طلبك رقم (<span>'.$quotation->order_number.'</span>). يرجى تخصيص لحظة وترك مراجعة للمورد</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                'description->ru' => '<p class="p-text">Ваш Заказ №(<span>'.$quotation->order_number.'</span>) выполнен. Пожалуйста, уделите немного времени и оставьте отзыв о поставщике.</p>',
                'description->ur' => '<p class="p-text">آپ کا آرڈر#(<span>'.$quotation->order_number.'</span>) مکمل ہو گیا ہے۔ برائے مہربانی ایک لمحہ چھوڑیں اور سپلائر کے لیے ایک جائزہ چھوڑیں۔</p>',
                'description->hi' => '<p class="p-text">आपका ऑर्डर#(<span>'.$quotation->order_number.'</span>) पूरा हो गया है। कृपया एक क्षण का समय दें और आपूर्तिकर्ता के लिए एक समीक्षा छोड़ दें</p>',
               
                'action' => 'REVIEW_SUPPLIER'
            ]);
            $reviewRepository = new ReviewRepository();
            $reviewCollection = collect([
                'id' => 0,
                'user_id' => $quotation->user_id,
                'order_id' => $quotation->id,
                'supplier_id' => 0,
                'service_id' => $quotation->service_id,
                'rating' => 0.0,
                'review' => null,
                'is_reviewed' => false,
            ]);
            $reviewSaveDto = ReviewSaveDto::fromCollection($reviewCollection);
            $reviewRepository->save($reviewSaveDto);
            sendNotification([ // send to user
                'sender_id' => $user->id,
                'receiver_id' => $quotation->user_id,
                'extras->order_id' => $quotation->id,
                'extras->service_id' => $quotation->service_id,
                'extras->service_slug' => $quotation->service->slug,
                'extras->service_name' => $quotation->service_name,
                'extras->image' => $quotation->service_image,
                'title->en' => 'Rate and review the Service.',
                'title->ar' => 'تقييم ومراجعة الخدمة.',
                'title->ru' => 'Оцените и просмотрите Сервис.',
                'title->ur' => 'سروس کی درجہ بندی اور جائزہ لیں۔',
                'title->hi' => 'सेवा को रेट करें और समीक्षा करें।',
                'description->en' => '<p class="p-text">Your Order#(<span>'.$quotation->order_number.'</span>) has been completed. Kindly spare a moment and leave a review for the service</p>',
                'description->ar' => '<p class="p-text">تم إكمال طلبك رقم (<span>'.$quotation->order_number.'</span>). يرجى تخصيص لحظة وترك مراجعة للخدمة</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                'description->ru' => '<p class="p-text">Ваш Заказ №(<span>'.$quotation->order_number.'</span>) выполнен. Уделите немного времени и оставьте отзыв об услуге</p>',
                'description->ur' => '<p class="p-text">Your Order#(<span>'.$quotation->order_number.'</span>) has been completed. Kindly spare a moment and leave a review for the service</p>',
                'description->hi' => '<p class="p-text">आपका ऑर्डर#(<span>'.$quotation->order_number.'</span>) पूरा हो गया है। कृपया एक क्षण का समय दें और सेवा के लिए एक समीक्षा छोड़ दें</p>',              
                'action' => 'REVIEW_SERVICE'
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function quote($request)
    {

        DB::beginTransaction();
        try {
            $quotation = $this->getModel()->with('orderItems')->where(['id' => $request->id])->first();

            $updateQuotation = [];
            $update = true;
            if ($quotation->status == 'confirmed' || $quotation->status == 'completed' || $quotation->status == 'cancelled' || $quotation->status == 'rejected') {
                $update = false;
            }
            if ($update) {
                $total = $quotation->total_amount;
                $subtotal = 0;


                if ($request->equipment) {
                    if ($quotation->issue_type == 'know') {
                        foreach ($request->equipment as $equipment) {
                            $item = OrderItem::where('order_id', $quotation->id)->where('equipment_id', $equipment['equipment_id'])->first();
                            $eq = Equipment::find($equipment['equipment_id']);
                            $price = $eq->price;
                            $equipmentObject = (object) $equipment;
                            $equipmentObject->price = $eq->price;
                            $equipmentObject->name = $eq->name;
                            $equipmentObject->image = $eq->image_url;
                            $equipmentObject->equipment_model = $eq->equipment_model;
                            $equipmentObject->make = $eq->make;

                            if ($item) {
                                $equipmentObject->qty_1 = $item->qty_1;
                                $equipmentObject->total_1 = $item->total_1;
                                $equipmentObject->qty_2 = $equipment['quantity'];
                                $equipmentObject->total_2 = $equipment['quantity'] * $equipmentObject->price;
                                $quantity = $item->quantity + $equipment['quantity'];
                                $equipmentObject->quantity = $quantity;
                                $item->delete();

                                $orderItem = $this->orderItemsRepository->save($equipmentObject, $quotation);
                                //   $total = $total + $price*$equipment['quantity'];
                                $subtotal = $subtotal + $price * $equipment['quantity'];
                            } else {
                                $equipmentObject->qty_1 = '0';
                                $equipmentObject->total_1 = '0.00';
                                $equipmentObject->qty_2 = $equipment['quantity'];
                                $equipmentObject->total_2 = $equipment['quantity'] * $equipmentObject->price;
                                $orderItem = $this->orderItemsRepository->save($equipmentObject, $quotation);
                                // $total = $total + $orderItem->total;
                                $subtotal = $subtotal + $orderItem->total;
                            }
                        }
                    } else {
                        foreach ($request->equipment as $equipment) {
                            $eq = Equipment::find($equipment['equipment_id']);
                            $price = $eq->price;
                            $equipmentObject = (object) $equipment;
                            $equipmentObject->price = $eq->price;
                            $equipmentObject->name = $eq->name;
                            $equipmentObject->image = $eq->image_url;
                            $equipmentObject->equipment_model = $eq->equipment_model;
                            $equipmentObject->make = $eq->make;
                            $equipmentObject->qty_1 = '0';
                            $equipmentObject->total_1 = '0.00';
                            $equipmentObject->qty_2 = $equipment['quantity'];
                            $equipmentObject->total_2 = $equipment['quantity'] * $equipmentObject->price;
                            $orderItem = $this->orderItemsRepository->save($equipmentObject, $quotation);
                            // $total = $total + $orderItem->total;
                            $subtotal = $subtotal + $orderItem->total;
                        }
                    }
                } else {
                    $subtotal = $quotation->subtotal;
                }
                $updateQuotation = [
                    'quoated_price' => $request->quoated_price,
                    'subtotal' => $subtotal,
                    'status' => $request->status
                ];
            }

            $quotation->update($updateQuotation);
            $user = $this->getUser();
            sendNotification([ // send to user
                'sender_id' => $user->id,
                'receiver_id' => $quotation->user_id,
                'extras->quotation_id' => $quotation->id,
                'extras->service_id' => $quotation->service_id,
                'extras->service_name' => $quotation->service_name,
                'extras->image' => $quotation->service_image,
                'title->en' => 'Supplier Has Quoted Price of a service',
                'title->ar' => 'حدد المورد سعر الخدمة',
                'title->ru' => 'Поставщик указал цену услуги',
                'title->ur' => 'سپلائر نے سروس کی قیمت کا حوالہ دیا ہے۔',
                'title->hi' => 'आपूर्तिकर्ता ने एक सेवा का मूल्य उद्धृत किया है',
                'description->en' => '<p class="p-text">Supplier has quoted a price against Quotation Request(<span>#'.$quotation->order_number.'</span>).Please visit the quotation detail page for further details</p>',
                'description->ar' => '<p class="p-text">قدم المورد سعرًا مقابل طلب عرض الأسعار (<span>#'.$quotation->order_number.'</span>). الرجاء زيارة صفحة تفاصيل عرض الأسعار للحصول على مزيد من التفاصيل</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                'description->ru' => '<p class="p-text">Поставщик указал цену в соответствии с запросом предложения (<span>#'.$quotation->order_number.'</span>). Пожалуйста, посетите страницу с подробным описанием предложения для получения дополнительной информации</p>',
                'description->ur' => '<p class="p-text">سپلائر نے کوٹیشن (<span>#'.$quotation->order_number.'</span>) کی درخواست کے مقابلے میں قیمت کا حوالہ دیا ہےمزید تفصیلات کے لیے براہ کرم کوٹیشن کی تفصیل کا صفحہ دیکھیں</p>',
                'description->hi' => '<p class="p-text">आपूर्तिकर्ता ने कोटेशन अनुरोध(<span>#'.$quotation->order_number.'</span>) के लिए एक मूल्य उद्धृत किया है। कृपया अधिक विवरण के लिए उद्धरण विवरण पृष्ठ पर जाएं।</p>',           
                'action' => 'QUOTATION'
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function reject($request)
    {

        DB::beginTransaction();
        try {
            $quotation = $this->getModel()->where(['id' => $request->id])->first();
            $quotationTransaction = OrderTransaction::where('order_id', $quotation->id)->first();
            $transactionDetail = json_decode($quotationTransaction->paypal_response);
            $amount = $transactionDetail->transactions[0]->amount->total;
            $transactionId = $transactionDetail->transactions[0]->related_resources[0]->sale->id;
            $updateQuotation = [];
            $update = true;
            if ($quotation->status == 'rejected') {
                throw new Exception(__('Quotation is already cancelled.'));
            }
            if ($quotation->status == 'quoted' || $quotation->status == 'confirmed' || $quotation->status == 'completed' || $quotation->status == 'cancelled' || $quotation->status == 'visited') {
                $update = false;
            }
            if ($update) {
                $this->refundPaypalPayment($amount, $transactionId);
                $updateQuotation = ['status' => $request->status];
            }
            $quotation->update($updateQuotation);
            $user = $this->getUser();
            if ($user->isSupplier()) {
                sendNotification([ // send to supplier
                    'sender_id' => $user->id,
                    'receiver_id' => $quotation->user_id,
                    'extras->quotation_id' => $quotation->id,
                    'extras->service_id' => $quotation->service_id,
                    'extras->service_name' => $quotation->service_name,
                    'extras->image' => $quotation->service_image,
                    'title->en' => 'Your Quotation Request Has Been Cancelled',
                    'title->ar' => 'Your Quotation Request Has Been Cancelled',
                    'description->en' => '<p class="p-text">Your Quotation (<span>Quotation#'.$quotation->order_number.'</span> ) has been cancelled. Please visit the quotation detail page for further details</p>',
                    'description->ar' => '<p class="p-text">Your Quotation (<span>Quotation#'.$quotation->order_number.'</span> ) has been cancelled. Please visit the quotation detail page for further details</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'action' => 'QUOTATION'
                ]);
            } else {
                sendNotification([ // send to user
                    'sender_id' => $user->id,
                    'receiver_id' => $quotation->supplier_id,
                    'extras->quotation_id' => $quotation->id,
                    'extras->service_id' => $quotation->service_id,
                    'extras->service_name' => $quotation->service_name,
                    'extras->image' => $quotation->service_image,
                    'title->en' => 'Quotation Request Has Been Cancelled',
                    'title->ar' => 'Quotation Request Has Been Cancelled',
                    'description->en' => '<p class="p-text">Quotation Request(<span>#'.$quotation->order_number.'</span> ) has been cancelled by the user. Please visit the quotation detail page for further details</p>',
                    'description->ar' => '<p class="p-text">Quotation Request(<span>#'.$quotation->order_number.'</span> ) has been cancelled by the user. Please visit the quotation detail page for further details</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'action' => 'QUOTATION'
                ]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function orderCancel($request)
    {
        DB::beginTransaction();
        try {
            $quotation = $this->getModel()->where(['id' => $request->id])->first();
            $quotationTransaction = OrderTransaction::where('order_id', $quotation->id)->skip(1)->first();
            $transactionDetail = json_decode($quotationTransaction->paypal_response);
            $amount = $transactionDetail->transactions[0]->amount->total;
            $transactionId = $transactionDetail->transactions[0]->related_resources[0]->sale->id;
            $updateQuotation = [];
            $update = true;
            if ($quotation->status == 'in-progress') {
                throw new Exception(__('Your order is already In Progress.'));
            }
            if ($quotation->status == 'in-progress' || $quotation->status == 'completed') {
                $update = false;
            }
            if ($update) {
                $this->refundPaypalPayment($amount, $transactionId);
                $updateQuotation = ['status' => $request->status];
            }
            $quotation->update($updateQuotation);
            $user = $this->getUser();
            if ($user->isSupplier()) {
                sendNotification([ // send to supplier
                    'sender_id' => $user->id,
                    'receiver_id' => $quotation->user_id,
                    'extras->order_id' => $quotation->id,
                    'extras->service_id' => $quotation->service_id,
                    'extras->service_name' => $quotation->service_name,
                    'extras->image' => $quotation->service_image,
                    'title->en' => 'You Order Has Been Cancelled',
                    'title->ar' => 'You Order Has Been Cancelled',
                    'description->en' => '<p class="p-text">Your Order# (<span>'.$quotation->order_number.'</span> ) has been cancelled by the supplier. Please visit the order details page for further details</p>',
                    'description->ar' => '<p class="p-text">Your Order# (<span>'.$quotation->order_number.'</span> ) has been cancelled by the supplier. Please visit the order details page for further details</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'action' => 'ORDER'
                ]);
            } else {
                sendNotification([ // send to user
                    'sender_id' => $user->id,
                    'receiver_id' => $quotation->supplier_id,
                    'extras->order_id' => $quotation->id,
                    'extras->service_id' => $quotation->service_id,
                    'extras->service_name' => $quotation->service_name,
                    'extras->image' => $quotation->service_image,
                    'title->en' => 'You Order Has Been Cancelled',
                    'title->ar' => 'You Order Has Been Cancelled',
                    'description->en' => '<p class="p-text">Your Order (<span>#'.$quotation->order_number.'</span> ) has been cancelled by the user. Please visit the order details page for further details</p>',
                    'description->ar' => '<p class="p-text">Your Order (<span>#'.$quotation->order_number.'</span> ) has been cancelled by the user. Please visit the order details page for further details</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'action' => 'ORDER'
                ]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function refundPaypalPayment($amount, $transactionId)
    {
        $this->initPayPal();
        $response = $this->refundPayment($amount, $transactionId);
        if ($response == 'error') {
            throw new Exception(__("payment refund failed"));
        }
    }
    public function generatePDF($id)
    {
        $this->setRelations(['orderTransactions', 'orderItems', 'orderItems.equipment', 'service', 'user', 'service.equipments', 'service.supplier', 'service.supplier.category']);
        $order = $this->get($id);
        // $Arabic = new Arabic();
        $html = view('front.dashboard.orders.invoice', ['order' => $order, 'loggedInUser' => $this->getUser()])->render();
        // $p = $Arabic->arIdentify($html);
        // for ($i = count($p) - 1; $i >= 0; $i -= 2) {
        //     $utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i - 1], $p[$i] - $p[$i - 1]));
        //     $html = substr_replace($html, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        // }
        $pdf = PDF::loadHTML($html);
        $format = '.pdf';
        $path = 'uploads/pdf/';
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        if ($order->status == 'completed') {
            $invoiceUrl = $order->invoice ?? '';
            // if ($invoiceUrl == "") {
                $fileName = $path . $order->order_number . $format;
                $pdf->save(env('PUBLIC_PATH') . $fileName);
                $order->update(['invoice' => $fileName]);

                $invoiceUrl = $fileName;
            // }
        } else {
            $invoiceUrl = $order->quotation_invoice ?? '';
            // if ($invoiceUrl == "") {
                $fileName = $path . $order->order_number . $order->order_number . $format;
                $pdf->save(env('PUBLIC_PATH') . $fileName);
                $order->update(['quotation_invoice' => $fileName]);

                $invoiceUrl = $fileName;
            // }
        }
        return $invoiceUrl;
    }

    public function sendInvoice($id)
    {
        $this->setRelations(['orderTransactions', 'orderItems', 'orderItems.equipment', 'service', 'user', 'service.equipments', 'service.supplier', 'service.supplier.category']);
        $order = $this->get($id);

        $sendEmailDto = SendEmailDto::fromCollection(collect([
            'receiver_email' => $this->getUser()->isSupplier() ? $order->supplier->email :  $order->user->email,
            'receiver_name' => $this->getUser()->isSupplier() ? $order->supplier->supplier_name['en'] :  $order->full_name,
            'subject' => 'Invoice for Order ID ' . $order->order_number,
            'view' => 'emails.user.invoice',
            'sender_name' => config('settings.company_name'),
            'sender_email' => config('settings.email'),
            'data' => ['order' => $order, 'loggedInUser' => $order->user],
        ]));
        SendMail::dispatch($sendEmailDto);
    }
}
