<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SubscriptionPackageRepository;
use App\Models\UserFeaturedSubscription;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
{

    public $subscriptionPackageRepository;

    public function __construct(SubscriptionPackageRepository $subscriptionPackageRepository)
    {
        parent::__construct();
        $this->subscriptionPackageRepository = $subscriptionPackageRepository;
        $this->subscriptionPackageRepository->setFromWeb(true);
    }

    public function index()
    {
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __('Subscription Package');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Subscription Package')];

        $this->subscriptionPackageRepository->setPaginate(6);
        $this->subscriptionPackageRepository->setSelect(['id', 'name', 'duration', 'duration_type', 'price', 'description']);
        $packages = $this->subscriptionPackageRepository->all(['supplier']);
        $user = auth()->user();
        if ($user->hasSubscriptions() && $user->isApproved()) {
            $userSubscription = $user->subscription()->first();
            if (isset($userSubscription->package)) {
                if (!$userSubscription->is_expired) {
                    $subscriptionId = $userSubscription->package['id'];
                    return view('front.dashboard.subscription.index', [
                        'packages' => $packages,
                        'subscriptionId' => $subscriptionId
                    ]);
                }
            }
        }
        $userSubscription = $user->subscription()->first();
        $subscriptionId='';
        if(isset($userSubscription->package))
        {
            if(!$userSubscription->is_expired)
            {
                $subscriptionId = $userSubscription->package['id'];
            }
        }
        return view('front.home.subscription.index', [
            'packages' => $packages,
            'subscriptionId' => $subscriptionId
        ]);
    }
    public function getFeatured()
    {
        $this->breadcrumbTitle = __('Feature Package');
        $this->breadcrumbs[0] = ['url' => route('front.index'), 'title' => __('Home')];
        $this->breadcrumbs[1] = ['url' => '', 'title' => __('Feature Package')];

        $this->subscriptionPackageRepository->setPaginate(6);
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
        // $subscriptionIds = [];
        // foreach ($userFeaturedSubscriptions as $subscriptionId) {
        //     if (isset($subscriptionId->package)) {
        //         if(!$subscriptionId->is_expired)
        //             {
        //                 $subscriptionIds[] = $subscriptionId->package['id'];
        //             }
        //         }
        //     }
    
  
        return view('front.dashboard.featured-subscription.index', [
            'packages' => $packages,
            // 'subscriptionIds' => $subscriptionIds,
            'purchasedPackages' => $buyPackages

        ]);
    }
}
