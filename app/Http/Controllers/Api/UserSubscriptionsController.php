<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Dtos\UserSubscriptionPaymentResponseDto;
use App\Http\Dtos\UserSubscriptionSaveDto;
use App\Http\Repositories\SubscriptionPackageRepository;
use App\Http\Repositories\UserSubscriptionRepository;
use App\Http\Requests\UserSubscriptionRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class UserSubscriptionsController extends Controller
{

    protected $userSubscriptionRepository,$subscriptionPackageRepository;

    public function __construct(UserSubscriptionRepository $userSubscriptionRepository,SubscriptionPackageRepository $subscriptionPackageRepository)
    {
        $this->userSubscriptionRepository = $userSubscriptionRepository;
        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
    }

    public function paymentResponse(UserSubscriptionRequest $request)
    {
        DB::beginTransaction();
        try {
            $package = $this->subscriptionPackageRepository->get($request->get('package_id'));
            if ($package->isFree()) {
                $newUserSubscriptionCollection = collect([
                    'user_subscription_package_id' => 0,
                    'user_id' => auth()->id(),
                    'package' => $package,
                    'is_expired' => false,
                    'payment_method' => 'free',
                    'aed_price' => $package->price,
                    'currency' => 'AED',
                ]);
                $newUserSubscriptionDto = UserSubscriptionSaveDto::fromCollection($newUserSubscriptionCollection);;
                $this->userSubscriptionRepository->save($newUserSubscriptionDto);
                DB::commit();
                return responseBuilder()->success(__('Subscription Package Successfully Purchased'));
            }
            $SubscriptionPaymentDetails = UserSubscriptionPaymentResponseDto::fromRequest($request);
            $subscription = $this->userSubscriptionRepository->paymentResponse($SubscriptionPaymentDetails);
            DB::commit();
            if ($request->subscription_type == 'featured') {
                return responseBuilder()->success(__('Featured Subscription Package Successfully Purchased'));
            } else {
                return responseBuilder()->success(__('Subscription Package Successfully Purchased'));
            }
     
        } catch (Exception $e) {
            DB::rollBack();
            return responseBuilder()->error($e->getMessage());
        }

    }
}
