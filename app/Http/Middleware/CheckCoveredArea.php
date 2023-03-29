<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Validation\ValidationException;

class CheckCoveredArea {

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
            if($user->city)
            {
                if ($user->coveredAreas()->get()->isEmpty()){
                    return redirect(route('front.auth.covered.areas'))->with('err', __('Please select at least one covered area.'));
                }
            }
            else
            {
                return redirect(route('front.auth.logout'))->with('err',__('Your  City is deleted from record'));
            }

        }
        return $next($request);
    }

}
