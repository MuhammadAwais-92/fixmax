<?php


namespace App\Http\Repositories;

use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Faq;
use App\Models\Order;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;

use function request;


class OrderTransactionRepository extends Repository
{
    protected $addressRepository;
    public function __construct()
    {
        $this->setModel(new OrderTransaction());
    }

    public function save($payment = null, $order=null)
    {
       
        $paymentData = $payment->toArray();

        return $this->getQuery()->create([
            'order_id' => $order->id,
            'payment_status' => 'confirmed',
            'payment_id' => (isset($paymentData['id'])) ? $paymentData['id'] : '',
            'payer_status' => (isset($paymentData['payer']['status'])) ? $paymentData['payer']['status'] : '',
            'payer_email' => (isset($paymentData['payer']['payer_info']['email'])) ? $paymentData['payer']['payer_info']['email'] : '',
            'payer_id' => (isset($paymentData['payer']['payer_info']['payer_id'])) ? $paymentData['payer']['payer_info']['payer_id'] : '',
            'charges' => (isset($paymentData['transactions'][0]['amount']['total'])) ? $paymentData['transactions'][0]['amount']['total'] : 0,
            'currency' => (isset($paymentData['transactions'][0]['amount']['currency'])) ? $paymentData['transactions'][0]['amount']['currency'] : 'USD',
            'transaction_details' => (isset($paymentData['transactions'][0]['amount']['details'])) ? json_encode($paymentData['transactions'][0]['amount']['details']) : '',
            'paypal_response' => $payment->toJSON(),
            'payment_method' => 'paypal',
        ]);

    }
}
