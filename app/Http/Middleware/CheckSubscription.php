<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Validation\ValidationException;

class CheckSubscription {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) {
        $user = auth()->user();
        if ($user->isSupplier()){
            if (!$user->isSubscribed()){
                return redirect(route('front.dashboard.packages.index'))->with('err', __('Please purchase a subscription package.'));
            }
            if (!$user->isApproved()){
                return redirect(route('front.dashboard.packages.index'));
            }
        }
        return $next($request);
    }

}
