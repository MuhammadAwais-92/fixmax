<?php

namespace App\Jobs;

use App\Models\AttributeProduct;
use App\Models\Cart;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\UserFeaturedSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeaturedSubscriptionExpiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $subscriptionId;
    public function __construct($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $featuredSubscription = UserFeaturedSubscription::find($this->subscriptionId);
        $service = Service::find($featuredSubscription->service_id);
        if ($service) {
                $featuredSubscription->update([
                    'is_expired' => 1
                ]);
                $service->update([
                    'is_featured' => 0,
                    'featured_expiry_date' => null,
                ]);
       
        }
    }
}
