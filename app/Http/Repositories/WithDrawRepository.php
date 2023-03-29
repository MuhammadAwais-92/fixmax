<?php


namespace App\Http\Repositories;

use Carbon\Carbon;
use App\Models\User;
use PayPal\Api\Item;
use App\Models\Coupon;
use PayPal\Api\Payment;
use App\Models\Withdraw;
use PayPal\Api\ItemList;
use Illuminate\Support\Str;
use PayPal\Api\PaymentExecution;
use App\Http\Libraries\DataTable;
use App\Traits\MyTechnologyPayPal;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\BaseRepository\Repository;


class WithDrawRepository extends Repository
{
    use MyTechnologyPayPal;

    protected $mall;
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->model = new Withdraw;
    }

    public function checkPaypalValidation($client_id = null, $secret_id = null)
    {
        if (!empty($client_id) && !empty($secret_id)) {

            $ch = curl_init();
            $clientId = $client_id;
            $secret = $secret_id;

            curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

            $result = json_decode(curl_exec($ch), true);

            if (!empty($result['error'])) {
                curl_close($ch);
                return false;
            } else {
                curl_close($ch);
                if (!empty($result['access_token'])) {
                    return true;
                }
                return false;
            }

            curl_close($ch);
        }
        return false;
    }

    public function save($request, $fromWeb = false)
    {

        $user = auth()->user();


        $count = $this->model->where([['user_id', $user->id], ['status', 'pending']])->count();
        if ($count > 0) {
            return false;
        }
        $withDraw = $this->model->create([
            'user_id'            => $user->id,
            'amount'             => $request->get('amount', 0),
            'additional_details' => $request->get('additional_details', ""),
            'method'             => 'paypal'
        ]);
        return $withDraw;
    }

    public function get()
    {
        $withdraws = Withdraw::where('user_id', $this->user['id'])->get();
        $amount = 0;
        if (count($withdraws) > 0) {
            foreach ($withdraws as $key => $withdraw) {
                if ($withdraw->status == 'completed') {
                    $amount += $withdraw->amount['omr']['amount'];
                }
            }
        }
        return view('front.dashboard.store.payment-profile', [
            'withdraws' => $withdraws->toArray(),
            'released_amount' => $amount
        ]);
    }

    public function all($id = null)
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'amount', 'dt' => 'amount'],
            ['db' => 'status', 'dt' => 'status'],
            ['db' => 'method', 'dt' => 'method'],
            ['db' => 'additional_details', 'dt' => 'additional_details'],
            ['db' => 'created_at', 'dt' => 'created_at'],
        ];
        $userWhere = function ($query) {
            $query->with('languages');
        };
        DataTable::init(new Withdraw(), $columns);
        DataTable::with('user');
        $store_id = \request('datatable.query.supplier_name', '');
        $status = \request('datatable.query.status', '');

        // if (!empty($store_id)) {
        //     DataTable::where('user_id', '=', intval($store_id));
        // }
        if (!empty($store_id)) {
            DataTable::wherehas('user', function ($q) use ($store_id) {
                $q->where('supplier_name', 'LIKE', '%' . $store_id . '%');
            });
        }
        if (!empty($id)) {
            DataTable::where('user_id', '=', intval($id));
        }

        if (!empty($status)) {
            DataTable::where('status', 'like', '%' . $status . '%');
        }

        $withdraws = DataTable::get();
        $perPage = \request('datatable.pagination.perpage', 1);
        $page    = \request('datatable.pagination.page', 1);
        $perPage = ($page * $perPage) - $perPage;

        $count = 0;


        if (sizeof($withdraws['data']) > 0) {
            $dateFormat = config('settings.date-format');

            foreach ($withdraws['data'] as $key => $item) {

                $count = $count + 1;
                $withdraws['data'][$key]['index'] = $count + $perPage;

                $actions = '';
                if (empty($item['user']->client_id) && empty($item['user']->secret_id)) {
                    $actions = 'kindly update paypal credential';
                } else if ($item['status'] == 'pending') {

                    if (strlen($item['user']->client_id) > 0 && strlen($item['user']->secret_id) > 0 && $item['method'] == 'paypal') {
                        $actions = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" href="' . route('admin.dashboard.withdraw.pay-with-paypal', ['id' => $item['id']]) . '" title="Pay with PayPal"><i class="fa fa-fw fa-paypal"></i></a>';
                    }
                }
                if ($item['status'] == 'complete') {
                    $actions = '---';
                }
                if ($item['status'] == 'rejected') {
                    $actions = '---';
                }
                $withdraws['data'][$key]['actions'] = $actions;
                
                if (!empty($item['user']['supplier_name']) && count($item['user']['supplier_name']) > 0) {
                    $withdraws['data'][$key]['supplier_name'] = $item['user']['supplier_name']['en'];
                } else {
                    $withdraws['data'][$key]['supplier_name'] = '';
                }
                $withdraws['data'][$key]['amount'] = $item['amount'];
                $withdraws['data'][$key]['status'] = ucfirst($item['status']);
                $withdraws['data'][$key]['created_at'] = Carbon::createFromTimestamp($item['created_at'])->format($dateFormat);
                unset($withdraws['data'][$key]['user']);
            }
        }

        return $withdraws;
    }

    public function reject($id)
    {
        $withdraw = $this->model->find($id);
        if (empty($withdraw)) {
            return responseBuilder()->error(__("Withdraw request not found"));
        }
        if ($withdraw->status != "pending") {
            return responseBuilder()->error(__("Bad request"));
        }
        try {
            DB::beginTransaction();
            $this->model->where(['id' => $id])->update([
                'status' => 'rejected',
            ]);
            DB::commit();
            return responseBuilder()->success(__("Withdraw request rejected successfully"));
        } catch (\Exception $e) {
            DB::rollBack();
            return responseBuilder()->error();
        }
    }

    public function payWithPayPal($id)
    {
        $withdraw = $this->model->with('user')->whereHas('user')->find($id);
        if (!empty($withdraw) && $withdraw->status == "pending" && (strlen($withdraw->user->client_id) > 0 || strlen($withdraw->user->secret_id) > 0)) {

            $this->initPayPal($withdraw->user->client_id, $withdraw->user->secret_id);


            $this->itemList = new ItemList();
            $paypalItem     = new Item();
            $name           = [
                'ar' => 'Withdraw request payment',
                'en' => 'Withdraw request payment'
            ];
            $desc = [
                'ar' => 'Requested by ' . $withdraw->user->email,
                'en' => 'Requested by ' . $withdraw->user->email
            ];
            $paypalItem->setName(Str::limit(translate($name), 250))
                ->setDescription(Str::limit(translate($desc), 225))
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice(getUsdPrice($withdraw->getOriginal('amount')));
            $this->itemList->addItem($paypalItem);

            $details = new \stdClass();

            $details->subtotal = number_format(getUsdPrice($withdraw->getOriginal('amount')), 2, '.', '');
            $this->subTotal = number_format(getUsdPrice($withdraw->getOriginal('amount')), 2, '.', '');
            return $this->doExpressCheckout(route('admin.dashboard.withdraw.paypal-payment-processed', ['id' => $withdraw->id]), route('admin.dashboard.withdraws.paypal-payment-canceled'));
        } else {
            return $withdraw;
        }
    }

    public function paypalPaymentProcessed($id)
    {
        $payerId  = request()->get('PayerID');
        $token    = request()->get('token');
        $withdraw = $this->model->with('user')->whereHas('user')->find($id);

        if (empty($withdraw)) {
            return $withdraw;
        }
        if ($withdraw->status != "pending") {
            return $withdraw;
        }
        if (strlen($withdraw->user->client_id) <= 0 || strlen($withdraw->user->secret_id) <= 0) {
            return $withdraw;
        }

        $this->initPayPal($withdraw->user->client_id, $withdraw->user->secret_id);
        // Get the payment ID before session clear
        $paymentId = session()->get('paypal_payment_id');
        // clear the session payment ID
        if (empty($payerId) || empty($token)) {
            session()->forget('paypal_payment_id');
            return [
                'url'    => route('admin.dashboard.withdraw.index'),
                'status' => 'error',
                'msg'    => __('Withdraw request not completed.')
            ];
        }
        $payment = Payment::get($paymentId, $this->apiContext);
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        //Execute the payment
        $result = $payment->execute($execution, $this->apiContext);
        if ($result->getState() == 'approved') {
            // payment made
            try {
                DB::beginTransaction();
                
                $user=$this->userRepository->getQuery()->where('id',$withdraw->user_id)->first();
                $balance=$user->available_balance-$withdraw->amount;
                // dd($balance);
                $user->update(['available_balance'=>$balance]);
                $this->model->where(['id' => $id])->update([
                    'status' => 'complete',
                ]);
                
                DB::commit();
                // sendNotification([
                //     'sender_id'            => $this->getUser()->id,
                //     'receiver_id'          => $withdraw->user_id,
                //     'extras->with_draw_id' => $withdraw->id,
                //     'extras->app_logo'     => url('images/favIcon.png'),
                //     'title->en'            => 'Payment Request',
                //     'title->ar'            => 'طلب الدفع',
                //     'description->en'      => 'Payment Request Completed',
                //     'description->ar'      => 'اكتمل طلب الدفع',
                //     'action'               => 'WITHDRAW'
                // ]);
                return [
                    'url'    => route('admin.dashboard.withdraw.index'),
                    'status' => 'status',
                    'msg'    => __('Withdraw request completed successfully.')
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                return [
                    'url'    => route('admin.dashboard.withdraw.index'),
                    'status' => 'error',
                    'msg'    => __('Something went wrong, please try later.')
                ];
            }
        } else {
            session()->forget('paypal_payment_id');

            return [
                'url' => route('admin.dashboard.withdraw.index'),
                'status' => 'error',
                'msg' => __('Payment failed! Request could not be completed.')
            ];
        }
    }

    public function paypalPaymentCanceled()
    {
        session()->forget('paypal_payment_id');
        return route('admin.withdraws.index');
    }

    public function payWithCash($id)
    {
        try {
            DB::beginTransaction();
            $this->model->where(['id' => $id])->update([
                'status' => 'completed',
            ]);
            DB::commit();
            return [
                'url' => route('admin.withdraws.index'),
                'status' => 'status',
                'msg' => __('Withdraw request completed successfully.')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'url' => route('admin.withdraws.index'),
                'status' => 'status',
                'msg' => __('Something went wrong, please try later.')
            ];
        }
    }
}
