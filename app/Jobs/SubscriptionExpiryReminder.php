<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SubscriptionExpiryReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $userId;


    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->userId);
        $todayDate = Carbon::parse(now()->endOfDay())->format("U");
        if (!is_null($user->expiry_date)){
            if ($user->expiry_date <= $todayDate){
               sendNotification([
                   'sender_id' =>$this->userId,
                   'receiver_id' => $this->userId,
                   'extras->notification_id' => 0,
                   'title->en' => 'Renew Subscription',
                   'title->ar' => 'Renew Subscription',
                   'description->en' => '<p class="p-text">Your subscription will expire in one day.</p>',
                   'description->ar' => '<p class="p-text">Your subscription will expire in one day.</p>',
                   'action' => 'SUBSCRIPTION_REMINDER'
               ]);
            }
        }

    }
}
