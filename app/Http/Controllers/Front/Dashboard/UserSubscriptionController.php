<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Dtos\UserSubscriptionPaymentDto;
use App\Http\Dtos\UserSubscriptionPaymentResponseDto;
use App\Http\Dtos\UserSubscriptionSaveDto;
use App\Http\Repositories\SubscriptionPackageRepository;
use App\Http\Repositories\UserSubscriptionRepository;
use App\Http\Requests\UserSubscriptionRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSubscriptionController extends Controller
{

    public $UserSubscriptionRepository, $subscriptionPackageRepository;

    public function __construct(UserSubscriptionRepository $UserSubscriptionRepository, SubscriptionPackageRepository $subscriptionPackageRepository)
    {
        parent::__construct();
        $this->UserSubscriptionRepository = $UserSubscriptionRepository;
        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
        $this->UserSubscriptionRepository->setFromWeb(true);
        $this->subscriptionPackageRepository->setFromWeb(true);
    }

    public function subscribe(UserSubscriptionRequest $request)
    {
        DB::beginTransaction();
        try {
            $package = $this->subscriptionPackageRepository->get($request->get('package_id'));
            if ($package->isFree()) {
                $newUserSubscriptionCollection = collect([
                    'user_subscription_package_id' => 0,
                    'user_id' => $this->user->id,
                    'package' => $package,
                    'is_expired' => false,
                    'payment_method' => 'free',
                    'aed_price' => $package->price,
                    'currency' => 'AED',
                ]);
                $newUserSubscriptionDto = UserSubscriptionSaveDto::fromCollection($newUserSubscriptionCollection);
                $this->UserSubscriptionRepository->save($newUserSubscriptionDto);
                DB::commit();
                return redirect()->route('front.dashboard.index')->with('status', __('Subscription Package Successfully Purchased'));
            } else {
                if ($package->isFeatured()) {
                    $newPayment = collect([
                        'package_id' => $package->id,
                        'name' => $package->name['en'],
                        'price' => $package->price,
                        'subscription_type' => $package->subscription_type,
                    ]);
                } else {
                    $newPayment = collect([
                        'package_id' => $package->id,
                        'name' => $package->name['en'],
                        'price' => $package->price,
                        'subscription_type' => $package->subscription_type,
                    ]);
                }
                $SubscriptionPaymentDetails = UserSubscriptionPaymentDto::fromCollection($newPayment);
                $url = $this->UserSubscriptionRepository->subscribeToPackage($SubscriptionPaymentDetails);
                DB::commit();
                return redirect($url);
            }
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->subscription_type == 'featured') {
                return redirect(route('front.dashboard.featured-packages.index'))->with('err', $e->getMessage());
            } else {
                return redirect(route('front.dashboard.packages.index'))->with('err', $e->getMessage());
            }
        }
    }

    public function paymentResponse(Request $request)
    {
        DB::beginTransaction();
        try {
            if(!($request->has('paymentId') &&  $request->has('PayerID')))
            {
                return redirect(route('front.dashboard.packages.index'));
            }
            $SubscriptionPaymentDetails = UserSubscriptionPaymentResponseDto::fromRequest($request);
            $subscription = $this->UserSubscriptionRepository->paymentResponse($SubscriptionPaymentDetails);
            DB::commit();
            if ($request->subscription_type == 'featured') {
                return redirect(route('front.dashboard.featured-packages.index'))->with('status', __('Feature Package purchased successfully.'));
            } else {
                return redirect(route('front.dashboard.index'))->with('status', __('Subscription Package Successfully Purchased'));
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect(route('front.dashboard.packages.index'))->with('err', $e->getMessage());
        }
    }
}
