<?php

namespace App\Jobs;

use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\UserSubscriptionRepository;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExpireCoupons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $couponRepository;


    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date=Carbon::parse(now())->format("Y-m-d");
        $today=DateToUnixformat($date);
        $coupon=Coupon::where("status","active")->get();
        foreach ($coupon as  $data) {
            if ($today == $data->end_date && !empty($data->end_date) || $today > $data->end_date && !empty($data->end_date)) {
                Coupon::where([["status", "=", "active"], ["id", $data->id],["end_date",'<=',$today]])->update(["status" => "expire"]);
            }
        }

    }
}
