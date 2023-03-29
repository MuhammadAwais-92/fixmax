<?php

namespace App\Http\Controllers\Api;


use App\Http\Repositories\UserRepository;
use App\Http\Repositories\WithDrawRepository;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;
use Response;

class WithdrawsController extends Controller
{

    protected $userRepository;
    protected $withDrawRepository;
    public function __construct(UserRepository $userRepository, WithDrawRepository $withDrawRepository)
    {
        $this->userRepository = $userRepository;
        $this->withDrawRepository = $withDrawRepository;
        $this->userRepository->setFromWeb(false);
        $this->withDrawRepository->setFromWeb(false);
    }

    public function paymentProfile()
    {
        $withdraws = Withdraw::where('user_id', auth()->user()->id)->get();

        $amount = 0;
        if (count($withdraws) > 0) {
            foreach ($withdraws as $key => $withdraw) {
                if ($withdraw->status == 'complete') {
                    $amount += $withdraw->amount;
                }
            }
        }
        return responseBuilder()->success(__('data'), [
            'withdraws' => $withdraws->toArray(),
            'released_amount' => $amount
        ]);
    }
    public function updatePaymentProfile(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'secret_id' => 'required',
        ]);
        try {
            $isUserValid = $this->withDrawRepository->checkPaypalValidation($request->get('client_id'), $request->get('secret_id'));
            if ($isUserValid) {
                $this->userRepository->getQuery()->where('id',auth()->user()->id)->update(['client_id' => $request->get('client_id'), 'secret_id' => $request->get('secret_id')]);
                    return responseBuilder()->success(__('Payment profile updated successfully.'));
            }
            return responseBuilder()->error('err', __('Credential is not Valid.'));
        } catch (Exception $e) {
            return redirect()->back()->with('Something went wrong');
        }
    }

    public function withdrawPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required'
        ]);
        if ($request->amount > \auth()->user()->available_balance) {
            return responseBuilder()->error(__('Amount is greater than available amount.'));
        }
        $withdraw = $this->withDrawRepository->save($request, $fromWeb = true);
        if ($withdraw == false) {
            return responseBuilder()->error(__('One request already in queue.'));
        }
        if ($withdraw) {
            return responseBuilder()->success(__('Withdraw request successful.'), $withdraw->toArray());
        }

        return responseBuilder()->error(__('Something went wrong.'));
    }
}
