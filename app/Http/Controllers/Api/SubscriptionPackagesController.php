<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SubscriptionPackageRepository;
use App\Models\UserFeaturedSubscription;
use Illuminate\Http\Request;

class SubscriptionPackagesController extends Controller
{

    protected $subscriptionPackageRepository;

    public function __construct(SubscriptionPackageRepository $subscriptionPackageRepository)
    {
        parent::__construct();
        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
    }

    public function index()
    {
        $this->subscriptionPackageRepository->setPaginate(0);
        $this->subscriptionPackageRepository->setSelect(['id', 'name', 'duration', 'duration_type', 'price', 'description', 'subscription_type']);
        $packages = $this->subscriptionPackageRepository->all(['supplier']);
        $subscriptionId = 0;
        $user = auth()->user();
        if ($user->hasSubscriptions() && $user->isApproved()) {
            $userSubscription = $user->subscription()->first();
            if (isset($userSubscription->package)) {
                if (!$userSubscription->is_expired) {
                    $subscriptionId = $userSubscription->package['id'];
                }
            }
        }
        return responseBuilder()->success(__('Subscription packages'),['packages'=>$packages, 'user_subscription_id'=> $subscriptionId]);
    }
    public function getActiveFeaturedPackages()
    {
      
        $user = auth()->user();
        $activeFeaturedSubscription = $user->getUserActiveFeaturedPackages();
    
        return responseBuilder()->success(__('Feature Subscription packages'),$activeFeaturedSubscription);
   
    }
    public function getFeatured(Request $request)
    {
        $this->subscriptionPackageRepository->setPaginate(0);
        $this->subscriptionPackageRepository->setSelect(['id', 'name', 'duration', 'duration_type', 'price', 'description','subscription_type']);
        $packages = $this->subscriptionPackageRepository->all(['featured']);
        
        $BuyPackage = [];
        $buyPackages = [];
        $user = auth()->user();
        $userFeaturedSubscriptions =  UserFeaturedSubscription::where('is_expired', 0)->where('service_id', 0)->where('user_id', $user->id)->get();
        foreach ($userFeaturedSubscriptions as $item) {
            $item['purchase_count'] = $user->userFeaturedSubscriptionCount($item->package['id']);
        }
        $i = 0;
        foreach ($userFeaturedSubscriptions as $item) {
            if (!in_array($item->package['id'], $BuyPackage)) {
                $BuyPackage[$i] = $item->package['id'];
                $buyPackages[$i] = $item;
            }
            $i++;
        }
        // $buyPackages = paginate($buyPackages, $request->url(), 0);
        return responseBuilder()->success(__('Feature packages'),['packages' => $packages,'purchasedPackages'=>$buyPackages]);
    
    }

}
