<?php

namespace App\Jobs;

use App\Models\AttributeProduct;
use App\Models\Cart;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceDiscountExpiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     protected $serviceId;
     public function __construct($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $service = Service::find($this->serviceId);
         if($service)
         {
             $service->update([
                 'discount'=> 0,
                 'expiry_date'=> null,
                 'service_type' =>'add-on'
             ]);
         }
    }
}
